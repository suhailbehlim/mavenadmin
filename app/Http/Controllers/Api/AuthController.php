<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Mail\UserForgetPassword;
use App\Mail\UserUpdatePassword;

use Illuminate\Support\Facades\Mail;



// import models here..
use App\Models\User;
use App\Models\Country;
use App\Models\Banners;
use App\Models\State;
use App\Models\City;
use App\Models\Company;
use App\Models\Category;
use App\Models\CarModel;
use App\Models\DealerOtherInfo;
use App\Models\Page;
use App\Models\PasswordReset;
use App\Models\Notification;


//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Input as input;

use Redirect;
use Illuminate\Support\Facades\Password;


// import JWTAuth here..
use JWTAuth;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

use File;
use Intervention\Image\ImageManagerStatic as Image;

use DB;


class AuthController extends Controller
{
    /**
     * Function name : index
     * Task : Show all required links for the app, this is the base url of the application.
     * Auther : Manish Silawat
     */
    public function index() {

        $baseUrl    = URL::to('/');
        $imageUrl   = $baseUrl . '/public/uploads/';

        $responseArray = [];

        $setImageUrl = [
            'user_image'                => $imageUrl . 'profile_images/',
            'user_image_thumbnail'      => $imageUrl . 'profile_images/thumbnail/',
            'user_image_default_image'  => $imageUrl . 'no_user.png',

            'compnay_doc_image'                => $imageUrl . 'dealer_documents/',
            'compnay_doc_image_thumbnail'      => $imageUrl . 'dealer_documents/thumbnail/',
            'compnay_doc_default_image'  => $imageUrl . 'no_doc.JPG',            

        ];

        $setHtmlUrl = [
            'website_url'       => $baseUrl,
            'api_url'           => $baseUrl . '/api/',
            'privacy_policy'    => $baseUrl . '/api/privacy-policy',
            'terms_of_services' => $baseUrl . '/api/terms-of-services',
           // 'FAQ'               => $baseUrl . '/api/faqs',
        ];

        $setUrl = [
            'image_urls'    => $setImageUrl,
            'html_urls'     => $setHtmlUrl,
        ];
        
        $responseArray = [
            'code'      => 200,
            'result'    => $setUrl,
            'message'   => 'Base Url',
            'success'   => true,
        ];
        $responseCode = 200;

        $response = Response::json($responseArray, $responseCode);
        return $response;
    }    

    /**
     * Function name : login
     * Task : Login user in the system.
     * Auther : Manish Silawat
     */
    public function login(Request $request) {

        $credentials = $request->only('email', 'password');
        // die('test');
        
        $validator = Validator::make($credentials, [
            'email'     => 'required|email|max:255',
            'password'  => 'required|min:6',
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

//            if($token = JWTAuth::attempt($credentials)){
            
                $userInfo = User::where('email', $credentials['email'])->first();

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

                // set token with userInfo array.
//                $userInfo['token'] = $token;

                // check user type to find user is customer or dealer
                if($userInfo['user_type'] == 'Dealer') {

                    // get dealer other information and send in response.
                    $dealerInfo = DealerOtherInfo::where('dealer_id', $userInfo['id'])->first();

                    $result['dealer_info'] = $dealerInfo;
                }

                $result['user_info'] = $userInfo; 
                
                // prepare response array here..
                $responseArray = [
                    'code'      => 200,
                    'result'    => $result,
                    'success'   => true,
                    'message'   => 'Login successfully.'
                ];
                $responseCode = 200;
    
//            } else {
//    
//                $responseArray = [
//                    'code'      => 406,
//                    'result'    => (object)[],
//                    'success'   => false,
//                    'message'   => 'User name or password is incorrect'
//                ];
//                $responseCode = 200;
//
//            }
        }

        $response = Response::json($responseArray, $responseCode);
        return $response;        
    }
    

    /**
     * Function name : customerRegister
     * Task : Normal user registration.
     * Auther : Manish Silawat
     */
    public function customerRegister(Request $request) {

        $requests = $request->only('first_name', 'last_name', 'email', 'phone_no', 'flat_no', 'password', 'city_id', 'state_id', 'country_id', 'device_id', 'notification_id');

        $validator = Validator::make($requests, [
            'first_name'        => 'required|min:2',
            'last_name'         => 'required|min:2',
            'email'             => 'required|email',
            'phone_no'          => 'required',
            'flat_no'           =>  'required',
            'password'          => 'required|min:6',
            'country_id'        =>  'required',
            'state_id'          =>  'required',
            'city_id'           =>  'required',
            'device_id'         => 'required',
            'notification_id'   => 'required',
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
            // check email exists..
            $user = $this->checkEmailExist(trim($request->email));

            if($user) {
        
                $responseArray = [
                    'code'      => 406,
                    'result'    => (object)[],
                    'success'   => false,
                    'message'   => 'Email is already exist.'
                ];
                $responseCode = 200;
    
            } else {

                // check phone no exists..
                $user = $this->checkPhoneNoExist(trim($requests['phone_no']));
                
                if($user){

                    $responseArray = [
                        'code'      => 406,
                        'result'    => (object)[],
                        'success'   => false,
                        'message'   => 'Phone no. is already exist.'
                    ];
                    $responseCode = 200;                    

                } else {

                    $user = User::create([
                        'user_type'         => 'Customer',
                        'first_name'        => trim($requests['first_name']),
                        'last_name'         => trim($requests['last_name']),
                        'name'              => trim($requests['first_name'].' '.$requests['last_name']),
                        'email'             => trim($requests['email']),
                        'password'          => Hash::make(trim($requests['password'])), 
                        'phone_no'          => trim($requests['phone_no']),
                        'flat_no'           => trim($requests['flat_no']),
                        'city_id'           => trim($requests['city_id']),
                        'state_id'          => trim($requests['state_id']),
                        'country_id'        => trim($requests['country_id']),
                        'device_id'         => trim($requests['device_id']),
                        'notification_id'   => trim($requests['notification_id']),
            
                    ]);
        
                    $token = JWTAuth::fromUser($user);
        
                    $user->token = $token;

                    if($user->country_id != 0) {
                        // get country details... 
                        $countryInfo = Country::select(['countries.name as country_name'])->where('id', $user->country_id)->first();
    
                        $user->country_name = $countryInfo['country_name'];
                    }
    
                    if($user->state_id != 0) {
                        // get state details... 
                        $stateInfo = State::select(['states.name as state_name'])->where('id', $user->state_id)->first();
    
                        $user->state_name = $stateInfo['state_name'];
                    }
    
                    if($user->city_id != 0) {
                        // get city details... 
                        $cityInfo = City::select(['cities.name as city_name'])->where('id', $user->city_id)->first();
    
                        $user->city_name = $cityInfo['city_name'];
                    }   

                    $result['user_info'] = $user;   

                    $responseArray = [
                        'code'      => 200,
                        'result'    => $result,
                        'success'   => true,
                        'message'   => 'Register successfully.'
                    ];
                    $responseCode = 200;


                }
            }
        }

        $response = Response::json($responseArray, $responseCode);
        return $response;           
    }


    /**
     * Function name : dealerRegister
     * Task : Dealer registration.
     * Auther : Manish Silawat
     */
    public function dealerRegister(Request $request) {

        $requests = $request->only('first_name', 'last_name', 'email', 'phone_no', 'flat_no', 'password', 'city_id', 'state_id', 'country_id', 'device_id', 'notification_id', 'company_name', 'company_doc');

        $validator = Validator::make($requests, [

            'first_name'        => 'required|min:2',
            'last_name'         => 'required|min:2',
            'email'             => 'required|email',
            'phone_no'          => 'required',
            'flat_no'           =>  'required',
            'password'          => 'required|min:6',
            'country_id'        =>  'required',
            'state_id'          =>  'required',
            'city_id'           =>  'required',
            'device_id'         => 'required',
            'notification_id'   => 'required',
            'company_name'      => 'required',
            'company_doc'       => 'required',

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
            // check email exists..
            $user = $this->checkEmailExist(trim($request->email));

            if($user) {
        
                $responseArray = [
                    'code'      => 406,
                    'result'    => (object)[],
                    'success'   => false,
                    'message'   => 'Email is already exist.'
                ];
                $responseCode = 200;
    
            } else {

                // check phone no exists..
                $user = $this->checkPhoneNoExist(trim($requests['phone_no']));
                
                if($user){

                    $responseArray = [
                        'code'      => 406,
                        'result'    => (object)[],
                        'success'   => false,
                        'message'   => 'Phone no. is already exist.'
                    ];
                    $responseCode = 200;                    

                } else {

                    $user = User::create([
                        'user_type'         => 'Dealer',
                        'first_name'        => trim($requests['first_name']),
                        'last_name'         => trim($requests['last_name']),
                        'name'              => trim($requests['first_name'].' '.$requests['last_name']),
                        'email'             => trim($requests['email']),
                        'password'          => Hash::make(trim($requests['password'])), 
                        'phone_no'          => trim($requests['phone_no']),
                        'flat_no'           => trim($requests['flat_no']),
                        'city_id'           => trim($requests['city_id']),
                        'state_id'          => trim($requests['state_id']),
                        'country_id'        => trim($requests['country_id']),
                        'device_id'         => trim($requests['device_id']),
                        'notification_id'   => trim($requests['notification_id']),
            
                    ]);
        
                    $token = JWTAuth::fromUser($user);
        
                    $user->token = $token;

                    if($user->country_id != 0) {
                        // get country details... 
                        $countryInfo = Country::select(['countries.name as country_name'])->where('id', $user->country_id)->first();
    
                        $user->country_name = $countryInfo['country_name'];
                    }
    
                    if($user->state_id != 0) {
                        // get state details... 
                        $stateInfo = State::select(['states.name as state_name'])->where('id', $user->state_id)->first();
    
                        $user->state_name = $stateInfo['state_name'];
                    }
    
                    if($user->city_id != 0) {
                        // get city details... 
                        $cityInfo = City::select(['cities.name as city_name'])->where('id', $user->city_id)->first();
    
                        $user->city_name = $cityInfo['city_name'];
                    }   

                    $result['user_info'] = $user;   


                    // upload company doc here.. 


                    $company_doc = '';

                    $file = $request->file('company_doc');
                    
                    if ($file && $file != '') {
            
                        $extension = $file->getClientOriginalExtension();
                        $imageName = getUniqueName($extension);
                        $storePath = 'uploads/dealer_documents/';
                        if ($file->move($storePath , $imageName)) {
                          //Create thumbnail
                          $thumbnailPath = $storePath . '/thumbnail/';
                          File::copy($storePath . $imageName, $thumbnailPath . $imageName);
                          Image::make($thumbnailPath . $imageName)
                            ->resize(60, 60)
                            ->save($thumbnailPath . $imageName);
                    
                          $company_doc = $imageName;
                        }
                    }                     

                    
                    // set dealer other information.
                    $dealerInfo = DealerOtherInfo::create([
                        'dealer_id'    =>  $user->id,
                        'company_name' =>  trim($requests['company_name']),
                        'company_doc' => $company_doc,
                        'is_approved' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    
                    // set dealer info to result array.. 
                    $result['dealer_info'] = $dealerInfo;

                    $responseArray = [
                        'code'      => 200,
                        'result'    => $result,
                        'success'   => true,
                        'message'   => 'Register successfully.'
                    ];
                    $responseCode = 200;


                }
            }
        }

        $response = Response::json($responseArray, $responseCode);
        return $response;           
    }

    /**
     * Function name : socialRegistration
     * Task : Social registration with facebook and google
     * Auther : Manish Silawat
     * NOTE : Social Registration is only for Customer User not for Dealer User..
     */
    public function socialRegistration(Request $request) {

        $requests = $request->only('social_id', 'first_name', 'last_name', 'email', 'phone_no', 'flat_no', 'city_id', 'state_id', 'country_id', 'device_id', 'notification_id');        

        $validator = Validator::make($requests, [

            'social_id'         => 'required',
            'first_name'        => 'required|min:2',
            'last_name'         => 'required|min:2',
            'email'             => 'required|email',
            'phone_no'          => 'required',
            'flat_no'           =>  'required',
            'country_id'        =>  'required',
            'state_id'          =>  'required',
            'city_id'           =>  'required',
            'device_id'         => 'required',
            'notification_id'   => 'required',
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

            // check already exists.. 
            if( User::where( ['social_id' => $requests['social_id'] ])->exists() ) {

                $responseArray = [
                    'code'      => 406,
                    'result'    => $validator->errors(),
                    'success'   => false,
                    'message'   => 'User already registered.'
                ];
                $responseCode = 200;

            } else {

                $user = User::create([

                    'first_name'        => trim($requests['first_name']),
                    'last_name'         => trim($requests['last_name']),
                    'name'              => trim($requests['first_name'].' '.$requests['last_name']),
                    'email'             => trim($requests['email']),
                    'phone_no'          => trim($requests['phone_no']),
                    'flat_no'           => trim($requests['flat_no']),
                    'city_id'           => trim($requests['city_id']),
                    'state_id'          => trim($requests['state_id']),
                    'country_id'        => trim($requests['country_id']),
                    'device_id'         => trim($requests['device_id']),
                    'notification_id'   => trim($requests['notification_id']),
                    'social_id'         => trim($requests['social_id']),
                    'user_type'         => 'Customer' 

        
                ]);
    
                $token = JWTAuth::fromUser($user);
    
                $user->token = $token;

                
                if($user->country_id != 0) {
                    // get country details... 
                    $countryInfo = Country::select(['countries.name as country_name'])->where('id', $user->country_id)->first();

                    $user->country_name = $countryInfo['country_name'];
                }

                if($user->state_id != 0) {
                    // get state details... 
                    $stateInfo = State::select(['states.name as state_name'])->where('id', $user->state_id)->first();

                    $user->state_name = $stateInfo['state_name'];
                }

                if($user->city_id != 0) {
                    // get city details... 
                    $cityInfo = City::select(['cities.name as city_name'])->where('id', $user->city_id)->first();

                    $user->city_name = $cityInfo['city_name'];
                }   

                $result['user_info'] = $user;   

        
                $responseArray = [
                    'code'      => 200,
                    'result'    => $result,
                    'success'   => true,
                    'message'   => 'User Register successfully.'
                ];
                $responseCode = 200;                

            }         
        }        

        $response = Response::json($responseArray, $responseCode);
        return $response; 
    }

    /**
     * Function name : checkEmailExist
     * Task : Check email in database
     * Auther : Manish Silawat
     */
    private function checkEmailExist($email) {
        $user = User::where('email', $email)->first();
        return $user; 
    }

    /**
     * Function name : checkPhoneNoExist
     * Task : Check phone no in database
     * Auther : Manish Silawat
     */
    private function checkPhoneNoExist($phoneNo) {
        $user = User::where('phone_no', $phoneNo)->first();
        return $user; 
    } 
    
    /**
     * Function name : bannerslist
     * Task : Get all states according to country
     * Auther : Sulekha Kumari
     */
    public function bannerslist(Request $request) {

            // get all countries..
        $allBanners =  Banners::get();
        // check db record count..
        $count = $allBanners->count();
        
        if( $count>0 ) {

            $responseArray = [
                'code'      => 200,
                'result'    => $allBanners,
                'message'   => 'Banners list',
                'success'   => true,
            ];

        } else {

            (object) [];

            $responseArray = [
                'code'      => 406,
                'result'    => (object) [],
                'message'   => 'No records found',
                'success'   => false,
            ];            
        }

        $responseCode = 200;
        $response = Response::json($responseArray, $responseCode);
        return $response;          
    }

    /**
     * Function name : countryList
     * Task : Get all country list
     * Auther : Manish Silawat
     */
    public function countryList() {
        // get all countries..
        $allCountries =  Country::get();
        // check db record count..
        $count = $allCountries->count();
        
        if( $count>0 ) {

            $responseArray = [
                'code'      => 200,
                'result'    => $allCountries,
                'message'   => 'Countries list',
                'success'   => true,
            ];

        } else {

            (object) [];

            $responseArray = [
                'code'      => 406,
                'result'    => (object) [],
                'message'   => 'No records found',
                'success'   => false,
            ];            
        }

        $responseCode = 200;
        $response = Response::json($responseArray, $responseCode);
        return $response;        
    }

    /**
     * Function name : stateList
     * Task : Get all states according to country
     * Auther : Manish Silawat
     */
    public function stateList(Request $request) {

        $requests = $request->only('country_id');

        $validator = Validator::make($requests, [
            'country_id' => 'required',
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
            
            $country_id = $requests['country_id'];

            // get all states according to country id..
            $allStates =  State::where('country_id', $country_id)->get();
            
            // check db record count..
            $count = $allStates->count();
            
            if( $count>0 ) {

                $responseArray = [
                    'code'      => 200,
                    'result'    => $allStates,
                    'message'   => 'State list',
                    'success'   => true,
                ];

            } else {

                (object) [];

                $responseArray = [
                    'code'      => 406,
                    'result'    => (object) [],
                    'message'   => 'No records found',
                    'success'   => false,
                ];            

            }
            $responseCode = 200;
        }        
        
        $response = Response::json($responseArray, $responseCode);
        return $response;        
    }


    public function profile(Request $request) {

        $requests = $request->only('user_id');

        $validator = Validator::make($requests, [
            'user_id' => 'required',
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
            
            $user_id = $requests['user_id'];

            
            $user =  User::find($user_id);
            
            
            
            if( $user ) {
                $baseUrl    = URL::to('/');
        $imageUrl   = $baseUrl . '/public/uploads/';
                $user->avatar = $imageUrl.'profile/'.$user->avatar;

                $responseArray = [
                    'code'      => 200,
                    'result'    => $user,
                    'message'   => 'User fetched successfully',
                    'success'   => true,
                ];

            } else {

                (object) [];

                $responseArray = [
                    'code'      => 406,
                    'result'    => (object) [],
                    'message'   => 'No records found',
                    'success'   => false,
                ];            

            }
            $responseCode = 200;
        }        
        
        $response = Response::json($responseArray, $responseCode);
        return $response;        
    }

    /**
     * Function name : cityList
     * Task : Get all cities according to sate
     * Auther : Manish Silawat
     */
    public function cityList(Request $request) {

        $requests = $request->only('state_id');

        $validator = Validator::make($requests, [
            'state_id' => 'required',
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
            
            $state_id = $requests['state_id'];

            // get all cities according to state id..
            $allCities =  City::where('state_id', $state_id)->get();
            
            // check db record count..
            $count = $allCities->count();
            
            if( $count>0 ) {

                $responseArray = [
                    'code'      => 200,
                    'result'    => $allCities,
                    'message'   => 'City list',
                    'success'   => true,
                ];

            } else {

                (object) [];

                $responseArray = [
                    'code'      => 406,
                    'result'    => (object) [],
                    'message'   => 'No records found',
                    'success'   => false,
                ];            

            }
            $responseCode = 200;
        }        
        
        $response = Response::json($responseArray, $responseCode);
        return $response;        
    }
    
    

    /**
     * Function name : companyList
     * Task : Get all company list
     * Auther : Manish Silawat
     */
    public function companyList() {
        // get all company..
        $allcompanies =  Company::get();
        // check db record count..
        $count = $allcompanies->count();
        
        if( $count>0 ) {

            $responseArray = [
                'code'      => 200,
                'result'    => $allcompanies,
                'message'   => 'Company list',
                'success'   => true,
            ];

        } else {

            (object) [];

            $responseArray = [
                'code'      => 406,
                'result'    => (object) [],
                'message'   => 'No records found',
                'success'   => false,
            ];            
        }

        $responseCode = 200;
        $response = Response::json($responseArray, $responseCode);
        return $response;        
    }

    /**
     * Function name : categoryList
     * Task : Get all category list
     * Auther : Manish Silawat
     */
    public function categoryList() {
        // get all categories..
        $allCategories =  Category::get();
        // check db record count..
        $count = $allCategories->count();
        
        if( $count>0 ) {

            $responseArray = [
                'code'      => 200,
                'result'    => $allCategories,
                'message'   => 'Category list',
                'success'   => true,
            ];

        } else {

            (object) [];

            $responseArray = [
                'code'      => 406,
                'result'    => (object) [],
                'message'   => 'No records found',
                'success'   => false,
            ];            
        }

        $responseCode = 200;
        $response = Response::json($responseArray, $responseCode);
        return $response;        
    }    


    /**
     * Function name : carModelList
     * Task : Get all car model list
     * Auther : Manish Silawat
     */
    public function carModelList() {
        // get all categories..
        $allModels =  CarModel::get();
        // check db record count..
        $count = $allModels->count();
        
        if( $count>0 ) {

            $responseArray = [
                'code'      => 200,
                'result'    => $allModels,
                'message'   => 'Car model list',
                'success'   => true,
            ];

        } else {

            (object) [];

            $responseArray = [
                'code'      => 406,
                'result'    => (object) [],
                'message'   => 'No records found',
                'success'   => false,
            ];            
        }

        $responseCode = 200;
        $response = Response::json($responseArray, $responseCode);
        return $response;        
    } 


    /**
     * Function name : notificationList
     * Task : Get all notification list
     * Auther : Manish Silawat
     */

    public function notificationList() {
        // get all categories..
        $allNotifications =  Notification::get();
        // check db record count..
        $count = $allNotifications->count();
        
        if( $count>0 ) {

            $responseArray = [
                'code'      => 200,
                'result'    => $allNotifications,
                'message'   => 'Notification list',
                'success'   => true,
            ];

        } else {

            (object) [];

            $responseArray = [
                'code'      => 406,
                'result'    => (object) [],
                'message'   => 'No records found',
                'success'   => false,
            ];            
        }

        $responseCode = 200;
        $response = Response::json($responseArray, $responseCode);
        return $response;        
    } 


    public function termsOfServices() {
        $data['page'] = Page::find(1);
        // load view for terms of services page..
        return view('api.contentPage', $data);
    }

    public function privacyPolicy() {
        $data['page'] = Page::find(2);
        // load view for privacy page..
        return view('api.contentPage', $data);
    }


    public function forgetPassword(Request $request)
    {
        $requests = $request->only('email');

        $validator = validator::make($requests, [
            'email' => 'required|email|max:255',
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

            $email = $requests['email'];

            // check email.
            $where = array('email' => $email);
            $email_exists = User::select('id', 'name')->where($where)->first();

            if ($email_exists) {

                // generate token.
                $passwordToken = md5(rand(1000, 9999));
                $url = url('/') . '/api/reset_password/' . $passwordToken;

                // create array for apply DB operation password resets table.
                $rest_data['email'] = $requests['email'];
                $rest_data['token'] = $passwordToken;

                // check email reset password table..
                $reset_password_email_exits = PasswordReset::select('email')
                    ->where(['email' => $email])->first();

                if ($reset_password_email_exits) {

                    PasswordReset::where(['email' => $email])->update($rest_data);

                } else {
                    PasswordReset::insertGetId($rest_data);
                }

                // email send code goes here..
                $mailData = [
                    'url' => $url,
                    'name' => $email_exists['name']
                ];

                // send mail..
                Mail::to($requests['email'])->send(new UserForgetPassword($mailData));


                // end.

                $responseArray = [
                    'code'      => 200,
                    'url'       => $url,
                    'success'   => true,
                    'message'   => 'Forget password email sent to user.',
                ];
                $responseCode = 200;                

            } else {

                $responseArray = [
                    'code'      => 406,
                    'success'   => false,
                    'message'   => 'Email address not registered.',
                ];
                $responseCode = 200;                    
            }
        }

        $response = Response::json($responseArray, $responseCode);
        return $response;
    }


    public function resetPassword($passwordToken)
    {
        if ($passwordToken != '') {
            $where = array('token' => $passwordToken);
            $result = PasswordReset::select('email')->where($where)->first();
        } else {
            $result = array();
        }

        if ($result) {
            // load change password view
            $data['password_token'] = $passwordToken;
            return view('api.changePassword', $data);
        } else {
            // load expire view
            $data['message'] = '';
            return view('api.resultMessage', $data);
        }
    }

    public function updatePassword(Request $request)
    {
        $requests = $request->only('password_token', 'confirm_new_password', 'new_password');

        $request->validate([
            'password_token'        => 'required',
            'new_password'         => 'required|min:6',
            'confirm_new_password' => 'required|same:new_password',
    
          ]);        

        // get password
        $password_token_id = $requests['password_token'];

        // get email according to token.
        $where = array('token' => $password_token_id);
        $email_info = PasswordReset::select('email')->where($where)->first();

        if ($email_info) {

            $email = $email_info->email;

            //update password in user table.
            $updates['password'] = bcrypt($requests['new_password']);
            $where_email = ['email' => $email];
            User::where($where_email)->update($updates);

            // update password reset table for blank token.
            $update_token['token'] = '';
            PasswordReset::where($where_email)->update($update_token);

            // Password changed email code goes here..

            // get user info.. by email
            $userInfo = User::where($where_email)->first(['id', 'name', 'email']);

            // email send code goes here..
            $mailData = [
                'password' => $requests['new_password'],
                'name' => $userInfo['name'],
                'email' => $userInfo['email'],
            ];

            // send mail..
            Mail::to($email)->send(new UserUpdatePassword($mailData));   
            
            // email send code end.. 

            //load success message view
            $data['message'] = "Your password has been changed successfully.";

            return view('api.resultMessage', $data);

        }
    }

}