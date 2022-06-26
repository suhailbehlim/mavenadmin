<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\DealerOtherInfo;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

use JWTAuth;
use Hash;
use DB;

class UserController extends Controller
{

    private function getUserInfoByToken()
    {
        // get id from token with JWT Auth
        $userInfo = JWTAuth::parseToken()->authenticate();

        // create array for ids
        $result['id'] = $userInfo->id;
        $result['user_type'] = $userInfo->user_type;

        return $result;

    }

    public function logout(Request $request)
    {
        // print_r($request->data()); exit;
        $requests = $request->header('Authorization');

        $expire = JWTAuth::invalidate(JWTAuth::getToken($request));

        $responseArray = [
            'code'      => 200,
            'result'    => (object) [],
            'message'   => 'Logout successfully',
            'success'   => true,
        ];
        $responseCode = 200;

        $response = Response::json($responseArray, $responseCode);
        return $response;

    }

    public function changePassword(Request $request)
    {
        $requests = $request->only('old_password', 'new_password', 'confirm_password');

        $validator = validator::make($requests, [

            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password',

        ]);

        if ($validator->fails()) {

            $responseArray = [
                'code'      => 406,
                'result'    => $validator->errors(),
                'success'   => false,
                'message'   => 'failed.'
            ];
            $responseCode = 200;

        } else {

            // get id from token with JWT Auth
            $user = JWTAuth::parseToken()->authenticate();
            $id = $user->id;

            //get user info
            $get_user = User::where('id', $id)->first(['password']);


            //get user info
            if ($get_user) {
                $stored_hash_password = $get_user->password;
                $old_pass = $requests['old_password'];

                if (Hash::check($old_pass, $stored_hash_password)) {

                    // The passwords match...
                    $newPassword = Hash::make($requests['new_password']);

                    //change password
                    $where = array('id' => $id);
                    $update_status = User::where($where)->update(['password' => $newPassword]);

                    if ($update_status) {

                        $responseArray = [
                            'code'      => 200,
                            'success'   => true,
                            'message'   => 'Password changed successfully.',
                        ];
                        $responseCode = 200;
                    
                    } else {

                        $responseArray = [
                            'code'      => 406,
                            'success'   => false,
                            'message'   => 'Password not changed.',
                        ];
                        $responseCode = 200;                         
                    }

                } else {

                    $responseArray = [
                        'code'      => 406,
                        'success'   => false,
                        'message'   => 'Old password field does not match',
                    ];
                    $responseCode = 200;                      

                }

            } else {

                $responseArray = [
                    'code'      => 406,
                    'success'   => false,
                    'message'   => 'User information not found.',
                ];
                $responseCode = 200;                  

            }
        }

        // send response..
        $response = Response::json($responseArray, $responseCode);
        return $response;
    }
    
    public function updateProfile(Request $request) {

        $requests = $request->only('first_name', 'last_name', 'email', 'phone_no', 'flat_no', 'state_id', 'city_id');

        $validator = Validator::make($requests, [
            'first_name'        => 'required|min:2',
            'last_name'         => 'required|min:2',
            'email'             => 'required|email',
            'phone_no'          => 'required',
            'flat_no'           =>  'required',
            //'country_id'        =>  'required',
            'state_id'          =>  'required',
            'city_id'           =>  'required',
        ]);

        if($validator->fails()) {

            $responseArray = [
                'code'      => 406,
                'result'    => $validator->errors(),
                'success'   => false,
                'message'   => 'failed.'
            ];
            $responseCode = 200;

        } else {

            // get id from token with JWT Auth
            $user = JWTAuth::parseToken()->authenticate();
            $id = $user->id;

            $email = $requests['email'];
            $phoneNo = $requests['phone_no'];

            // check email exist.. 
            $checEmail = DB::select(DB::raw("SELECT id
            FROM `users`
            WHERE id != $id
            AND email = '$email' "));            

            if($checEmail) {
                

                $responseArray = [
                    'code'      => 406,
                    'result'    => (object) [],
                    'success'   => false,
                    'message'   => 'Email already exist.'
                ];
                $responseCode = 200;


            } else {
               

                // check phone no. exist.. 
                $checPhoneNo = DB::select(DB::raw("SELECT id
                FROM `users`
                WHERE id != $id
                AND phone_no = $phoneNo ")); 
                
                if($checPhoneNo) {

                    $responseArray = [
                        'code'      => 406,
                        'result'    => (object) [],
                        'success'   => false,
                        'message'   => 'Phone no. already exist.'
                    ];
                    $responseCode = 200;                    

                } else {

                    // update user information..
                    User::where(['id' => $id])->update([

                        'first_name'        =>trim($requests['first_name']),
                        'last_name'         => trim($requests['last_name']),
                        'name'              => trim(ucwords($requests['first_name'].' '. $requests['last_name'] )),
                        'email'             => trim($requests['email']),
                        'phone_no'          => trim($requests['phone_no']),
                        'flat_no'           => trim($requests['flat_no']),
                        'state_id'          => $requests['state_id'],
                        'city_id'           => $requests['city_id'],
                    ]);

                    // get user updated information. 
                    $userInfo = User::where('id', $id)->first();


                    if($userInfo['country_id'] != 0) {
                        // get country details... 
                        $countryInfo = Country::select(['countries.name as country_name'])->where('id', $userInfo['country_id'])->first();
    
                        $userInfo['country_name'] = $countryInfo['country_name'];
                    }
    
                    if($userInfo['state_id'] != 0) {
                        // get state details... 
                        $stateInfo = State::select(['states.name as state_name'])->where('id', $userInfo['state_id'])->first();
    
                        $userInfo['state_name'] = $stateInfo['state_name'];
                    }
    
                    if($userInfo['city_id'] != 0) {
                        // get city details... 
                        $cityInfo = City::select(['cities.name as city_name'])->where('id', $userInfo['city_id'])->first();
    
                        $userInfo['city_name'] = $cityInfo['city_name'];
                    }   

                    $result['user_info'] = $userInfo; 


                    // check user type to find user is customer or dealer
                    if($userInfo['user_type'] == 'Dealer') {

                        // get dealer other information and send in response.
                        $dealerInfo = DealerOtherInfo::where('dealer_id', $userInfo['id'])->first();

                        $result['dealer_info'] = $dealerInfo;
                    }                    



                    $responseArray = [
                        'code'      => 200,
                        'result'    => $result,
                        'success'   => true,
                        'message'   => 'Profile updated successfully.',
                    ];
                    $responseCode = 200;

                }
            }
        }

        // send response..
        $response = Response::json($responseArray, $responseCode);
        return $response;
    }


}