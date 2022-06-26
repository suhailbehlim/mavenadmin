<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
//use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\SendMail;

use File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\CourseDescription;
use App\Models\cms_section;
use App\Models\subscriber;
use Hash;
use DB;

class ApiController extends Controller
{
	public function subs_list(Request $req)
	{
		$office			 = new subscriber;
		$office->name		=$req->name;
		$office->email	=$req->email;
		
		$result = $office->save();
		
		if($result)
		{
		return ["result"=>"data sent"];
		}
		else{
			return ["result"=>"data could not be sent"];
		}
	}
     public function register_user(Request $request){
        $name=$request->name;
		$phone=$request->phone;
		$email=$request->email;
		$password=$request->password;
        $address=$request->address;
        $device_id=$request->device_id;
		$age=$request->age;
		$education_history=$request->education_history;
        

		if(!isset($name)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Name is required.");
		}else if(!isset($phone)){
			$result=array("code" => 201 , "success" => "false" , "message" => "phone is required.");
		}else if(!isset($email)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Valid Email is required.");
		}else if(!isset($password)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Password is required.");
		}else{
			$date = date("Y-m-d H:i:s", time());
            $user = DB::table('users')->where('email',$email)->whereOr('phone',$phone)->select('email','phone')->first();
            if($user && $user->email==$email)
            {
				$result=array("code" => 201 , "success" => "false" , "message" => "Email already exists, please try another.");
            }else if($user && $user->phone==$phone)
            {
                $result=array("code" => 201 , "success" => "false" , "message" => "Phone already exists, please try another.");
            }else
            {
                $data = [
                    'user_type'  => 'student',
					'role_id'  => 4,
                    'username' => trim($email),
					'password'   => Hash::make($password), 
                    'name'  => trim($name),
                    'email'      => trim($email),
                    'phone'   => trim($phone),
                    'age'   => trim($age),
                    'education_history'    => trim($education_history),
                    'address'    => trim($address),
                    'income'   => 0,
                    'device_id' => trim($device_id),
					'status'  => 'Inactive',
                    'created_at'  => $date,
                    'updated_at'  => $date,
                ];
                $adduser =DB::table('users')->insert($data);
                if($adduser){
                    $result=array("code" => 200 , "success" => "true" , "message" => "User added successfully.");
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }	
		}        
        $response = Response::json($result);
        return $response;
    }
	
	public function user_login(Request $request){
		$email = $request->email;
        $password = $request->password;
		$userInfo = DB::table('users')->where('email', $email)->first();
		
		if(!empty($userInfo)){
			if (!Hash::check($password, $userInfo->password)) {
				$result=array("code" => 201 , "success" => "false" , "message" => 'Invalid login details.');
			}else{
				if($userInfo->status == 'Inactive'){
					$result=array("code" => 201 , "success" => "false" , "message" => 'Your account is not yet approved');
				}else{
					$ssltoken = openssl_random_pseudo_bytes(30);
					$remember_token = bin2hex($ssltoken);
					$update =DB::table('users')->where('id', $userInfo->id)->update(['remember_token'=>$remember_token]);
					$userInfo->remember_token = $remember_token;
					$result=array("code" => 200 , "success" => "true" , "message" => "Login Successful." , "data" => $userInfo);
				}
			}
		}else{
			$result=array("code" => 201 , "success" => "false" , "message" => 'Account not found.');
		}
		$response = Response::json($result);
        return $response;
    }
	
	public function forgot_password(Request $request){       
        $email=$request->email;
		if(!isset($email)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Email is required.");
		}else{
            $user = DB::table('users')->where('email',$email)->select('id','email','phone')->first();
            if($user && $user->email==$email){
                $user_id = $user->id;
				DB::table('users')->where('id', $user_id)->update(['otp'=>12345]); 
				$result=array("code" => 200 , "success" => "true" , "message" => "pasword change request successfully." , "data" => ['user_id'=>$user_id,'otp'=>12345]);				
            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "Email Not exists, please try another.");
            }           
            
		}        
        $response = Response::json($result);
        return $response;
    }
	public function verify_otp(Request $request){       
        $user_id=$request->user_id;
		$otp=$request->otp;
		if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "user_id is required.");
		}else if(!isset($otp)){
			$result=array("code" => 201 , "success" => "false" , "message" => "otp is required.");
		}else{
            $user = DB::table('users')->where('id',$user_id)->where('otp',$otp)->first();
            if($user){
				$result=array("code" => 200 , "success" => "true" , "message" => "OTP Verified successfully." , "data" => ['user_id'=>$user->id]);				
            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "Otp not matched.");
            }           
            
		}        
        $response = Response::json($result);
        return $response;
    }
	public function change_password(Request $request){       
        $user_id=$request->user_id;
		$password=$request->password;
		if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "user_id is required.");
		}else if(!isset($password)){
			$result=array("code" => 201 , "success" => "false" , "message" => "password is required.");
		}else{
            $user = DB::table('users')->where('id',$user_id)->first();
            if($user){
				DB::table('users')->where('id', $user_id)->update(['password'=>Hash::make($password)]); 
				$result=array("code" => 200 , "success" => "true" , "message" => "Password changed successfully." , "data" => ['user_id'=>$user->id]);				
            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "User not matched.");
            }           
            
		}        
        $response = Response::json($result);
        return $response;
    }
	public function profileUser(Request $request){       
        $user_id=$request->user_id;
		if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "user_id is required.");
		}else{
            $user = DB::table('users')->where('id',$user_id)->first();
            if($user){
				$result=array("code" => 200 , "success" => "true" , "message" => "Successfully." , "data" => $user);				
            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "User not matched.");
            }           
            
		}        
        $response = Response::json($result);
        return $response;
    }
    
    public function courses_categories(){
        $getCountries =DB::table('categories')->where('status','Active')->orderBy('id', 'DESC')->get();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/courses_category/';
		$finalBanners = array();
		foreach ($getCountries as $p) {
			$p->image = $imageUrl.$p->image;
			array_push($finalBanners, $p->image);
		}

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        
		$response = Response::json($result);
        return $response;
    }
	
	public function courses_by_category($id){
        $getCountries =DB::table('courses')->where('category',$id)->orderBy('id', 'DESC')->get();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/courses/';
		$finalBanners = array();
		foreach ($getCountries as $p) {
			$p->thumbnail = $imageUrl.$p->thumbnail;
			$p->main_image = $imageUrl.$p->main_image;
			$p->gallery_images = $imageUrl.$p->gallery_images;
			array_push($finalBanners, $p->thumbnail);
		}

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        
		$response = Response::json($result);
        return $response;
    }
	public function vlsi_workshop(){
        $getCountries =DB::table('workshop')->where('id',1)->first();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/global/';
		$finalBanners = array();
		$getCountries->first_icon = $imageUrl.$getCountries->first_icon;
		$getCountries->first_image = $imageUrl.$getCountries->first_image;
		$getCountries->second_icon = $imageUrl.$getCountries->second_icon;
		$getCountries->second_image = $imageUrl.$getCountries->second_image;

		$datas =DB::table('life_banners')->orderBy('id', 'DESC')->get();
		$finalBanners2 = array();
		foreach ($datas as $p) {
			$p->banner = $imageUrl.$p->banner;
			array_push($finalBanners2, $p->banner);
		}
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries , 'life_banners'=>$datas);
        
		$response = Response::json($result);
        return $response;
    }
	public function search(Request $request){     
        $search=$request->search;
		if($search){
        $getCountries =DB::table('courses')->where('title','LIKE','%'.$search.'%')->where('status','Active')->get();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/courses/';
		$finalBanners = array();
		foreach ($getCountries as $p) {
			$p->thumbnail = $imageUrl.$p->thumbnail;
			$p->main_image = $imageUrl.$p->main_image;
			$p->gallery_images = $imageUrl.$p->gallery_images;
			array_push($finalBanners, $p->thumbnail);
		}

			$result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        }else{
			$result=array("code" => 201 , "success" => "true" , "message" => "Record not Found" , 'data'=>(object)[]);
		}
		$response = Response::json($result);
        return $response;
    }
    public function course_description($id){
        $CourseDescription = CourseDescription::with('CourseFeatures','AdmissionProcess','ScholarshipScheme','BatchCalendar','WinningDifference')->where('courseID',$id)->first();
        
      
         if (isset($CourseDescription->whatWeLearnImage)) {
        	$CourseDescription->whatWeLearnImage = asset('/public/system/courses/whatWeLearnImage/'.$CourseDescription->whatWeLearnImage);
        }
        if (isset($CourseDescription->placementImage)) {
        	$CourseDescription->placementImage = asset('/public/system/courses/placementImage/'.$CourseDescription->placementImage);
        }
         if (isset($CourseDescription->courseDetailsImage)) {
        	 $CourseDescription->courseDetailsImage = asset('/public/system/courses/courseDetailsImage/'.$CourseDescription->courseDetailsImage);
        }
          if (isset($CourseDescription->courseDetailsFaq)) {
        	  $CourseDescription->courseDetailsFaq = unserialize($CourseDescription->courseDetailsFaq);
        }
 
        	
      
       
          // $CourseDescription->WinningDifference['icon'] = asset('/public/system/courses/Winning_Difference/'.$CourseDescription->WinningDifference['icon']);
       
        // dd( $CourseDescription);
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$CourseDescription);
        
		$response = Response::json($result);
        return $response;
    }
    public function cms_section($page){
        $cms_section = cms_section::where('pageName',$page)->get();
        
       
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$cms_section);
        
		$response = Response::json($result);
        return $response;
    }
	public function course_detail($id){
        $getCountries =DB::table('courses')->where('id',$id)->first();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/courses/';
		$getCountries->thumbnail = $imageUrl.$getCountries->thumbnail;
		$getCountries->main_image = $imageUrl.$getCountries->main_image;
		$getCountries->gallery_images = $imageUrl.$getCountries->gallery_images;
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        
		$response = Response::json($result);
        return $response;
    }
	
	public function cart_list($user_id){
        $getCountries =DB::table('cart')->where('user_id',$user_id)->get();
		$array = [];
		if($getCountries){
			foreach($getCountries as $key=>$val){
				$cours = DB::table('courses')->where('id',$val->course_id)->first();
				$baseUrl    = URL::to('/');
				$imageUrl   = $baseUrl . '/public/system/courses/';
				$cours->thumbnail = $imageUrl.$cours->thumbnail;
				$cours->main_image = $imageUrl.$cours->main_image;
				$cours->gallery_images = $imageUrl.$cours->gallery_images;
				$array[$key]['cart_id'] = $val->id;
				$array[$key]['user_id'] = $val->user_id;
				$array[$key]['course_id'] = $val->course_id;
				$array[$key]['qty'] = $val->qty;
				$array[$key]['created_at'] = $val->created_at;
				$array[$key]['course_detail'] = $cours;
			}
		}
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$array);
        
		$response = Response::json($result);
        return $response;
    }
    
    public function add_to_cart(Request $request){
        $user_id=$request->user_id;
		$course_id=$request->course_id;
		$qty=$request->qty;
        $date = date("Y-m-d h:i:s", time());

		if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "user_id is required.");
		}else if(!isset($course_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "course_id is required.");
		}else if(!isset($qty)){
			$result=array("code" => 201 , "success" => "false" , "message" => "qty is required.");
		}else{
			$check =DB::table('cart')->where('course_id',$course_id)->where('user_id',$user_id)->select('qty')->first();
			if($check){
				DB::table('cart')->where('course_id',$course_id)->where('user_id',$user_id)->update(['qty'=>$qty+$check->qty]);
				$result=array('status'=>200,'message'=> 'Added in cart successfully.');
			}else{
				$data = ['course_id'=>$course_id,'qty'=>$qty,'user_id'=>$user_id,'created_at'=>$date,'updated_at'=>$date];
				$cart = DB::table('cart')->insert($data);
				if($cart){
					$result=array('status'=>200,'message'=> 'Added in cart successfully.');
				}else{
					$result=array('status'=>201,'message'=> 'Something went wrong. Please try again.');
				}
			}	
		}        
        $response = Response::json($result);
        return $response;
    }
	
	public function update_cart(Request $request){
        $user_id=$request->user_id;
		$course_id=$request->course_id;
		$qty=$request->qty;
        $date = date("Y-m-d h:i:s", time());

		if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "user_id is required.");
		}else if(!isset($course_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "course_id is required.");
		}else if(!isset($qty)){
			$result=array("code" => 201 , "success" => "false" , "message" => "qty is required.");
		}else{
			$check =DB::table('cart')->where('course_id',$course_id)->where('user_id',$user_id)->select('qty')->first();
			if($check){
				DB::table('cart')->where('course_id',$course_id)->where('user_id',$user_id)->update(['qty'=>$qty+$check->qty]);
				$result=array('status'=>200,'message'=> 'Added in cart successfully.');
			}else{
				$result=array('status'=>201,'message'=> 'Something went wrong. Please try again.');
			}	
		}        
        $response = Response::json($result);
        return $response;
    }
	
	public function remove_cart($id){
		if(!isset($id)){
			$result=array('status'=>201,'message'=> 'item id is required.');
		}else{
			$cart =DB::table('cart')->where('id',$id)->delete();
			if($cart){
				$result=array('status'=>200,'message'=> 'Removed from cart successfully.');
			}else{
				$result=array('status'=>201,'message'=> 'Data not found. Please try again.');
			}
		}
		echo json_encode($result);
    }
	
	
	public function add_to_wishlist(Request $request){
        $user_id=$request->user_id;
		$course_id=$request->course_id;
        $date = date("Y-m-d h:i:s", time());

		if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "user_id is required.");
		}else if(!isset($course_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "course_id is required.");
		}else{
			$check =DB::table('wishlist')->where('course_id',$course_id)->where('user_id',$user_id)->first();
			if($check){
				$result=array('status'=>200,'message'=> 'Already Added in wishlist successfully.');
			}else{
				$data = ['course_id'=>$course_id,'user_id'=>$user_id];
				$cart = DB::table('wishlist')->insert($data);
				if($cart){
					$result=array('status'=>200,'message'=> 'Added in wishlist successfully.');
				}else{
					$result=array('status'=>201,'message'=> 'Something went wrong. Please try again.');
				}
			}	
		}        
        $response = Response::json($result);
        return $response;
    }
	
	public function remove_wishlist(Request $request){
        $user_id=$request->user_id;
		$course_id=$request->course_id;

		if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "user_id is required.");
		}else if(!isset($course_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "course_id is required.");
		}else{
			$check =DB::table('wishlist')->where('course_id',$course_id)->where('user_id',$user_id)->first();
			if($check){
				$cart =DB::table('wishlist')->where('course_id',$course_id)->where('user_id',$user_id)->delete();
				$result=array('status'=>200,'message'=> 'Deleted from wishlist successfully.');
			}else{
				$result=array('status'=>201,'message'=> 'Something went wrong. Please try again.');
			}	
		}        
        $response = Response::json($result);
        return $response;
    }
	
	public function wishlist($user_id){
        $getCountries =DB::table('wishlist')->where('user_id',$user_id)->get();
		$array = [];
		if($getCountries){
			foreach($getCountries as $key=>$val){
				$cours = DB::table('courses')->where('id',$val->course_id)->first();
				$baseUrl    = URL::to('/');
				$imageUrl   = $baseUrl . '/public/system/courses/';
				$cours->thumbnail = $imageUrl.$cours->thumbnail;
				$cours->main_image = $imageUrl.$cours->main_image;
				$cours->gallery_images = $imageUrl.$cours->gallery_images;
				$array[$key]['id'] = $val->id;
				$array[$key]['user_id'] = $val->user_id;
				$array[$key]['course_id'] = $val->course_id;
				$array[$key]['course_detail'] = $cours;
			}
		}
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$array);
        
		$response = Response::json($result);
        return $response;
    }
	public function event_list(){
        $getCountries =DB::table('events')->where('status','Active')->orderBy('id', 'DESC')->get();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/events/';
		$finalBanners = array();
		foreach ($getCountries as $p) {
			$p->image = $imageUrl.$p->image;
			array_push($finalBanners, $p->image);
		}

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        
		$response = Response::json($result);
        return $response;
    }
	
	public function event_detail($id){
        $getCountries =DB::table('events')->where('id',$id)->first();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/events/';
		$getCountries->image = $imageUrl.$getCountries->image;
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        
		$response = Response::json($result);
        return $response;
    }
	
	public function skills_list(){
        $getCountries =DB::table('skills')->where('status','Active')->orderBy('id', 'DESC')->get();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/skills/';
		$finalBanners = array();
		foreach ($getCountries as $p) {
			$p->image = $imageUrl.$p->image;
			array_push($finalBanners, $p->image);
		}
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        
		$response = Response::json($result);
        return $response;
    }
	
	public function courses_by_skill($id){
        $getCountries =DB::table('courses')->where('skill',$id)->orderBy('id', 'DESC')->get();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/courses/';
		$finalBanners = array();
		foreach ($getCountries as $p) {
			$p->thumbnail = $imageUrl.$p->thumbnail;
			$p->main_image = $imageUrl.$p->main_image;
			$p->gallery_images = $imageUrl.$p->gallery_images;
			array_push($finalBanners, $p->thumbnail);
		}

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        
		$response = Response::json($result);
        return $response;
    }
	
	
    public function stateList(Request $request){
        $country_id = $request['country_id'];
        
        // get all states according to country id..
        $allStates =DB::table('states')->where('country_id', $country_id)->select('id','name')->orderBy('id', 'DESC')->get();
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$allStates);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : bannerslist
     * Task : Get all states according to country
     * Auther : Sulekha Kumari
     */
    
    public function bannerslist(Request $request) {
        
        $getBanners =DB::table('banners')->where('status', 'Active')->select('id','title','alt','desktop_banner','mobile_banner')->orderBy('id', 'DESC')->get();
        $finalBanners = array();
        
        $baseUrl    = URL::to('/');
        $imageUrl   = $baseUrl . '/public/uploads/banners/';
        
        foreach ($getBanners as $p) {
            $p->desktop_banner = $imageUrl.$p->desktop_banner;
            array_push($finalBanners, $p->desktop_banner);
        }
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$finalBanners);
        
		$response = Response::json($result);
        return $response;        
    }
    
    /**
     * Function name : makelist
     * Task : Get all make (i.e companies)
     * Auther : Sulekha Kumari
     */
    
    public function makelist() {
        
        $getMake =DB::table('companies')->select('id','title')->orderBy('id', 'DESC')->get();
        
        foreach ($getMake as $make) {
            $make_id = 0;
            $getmodal = '';
            
            $make_id = $make->id;
            $getmodal =DB::table('car_models')->where('make', $make_id)->select('id','title','trim')->orderBy('id', 'DESC')->get();
            $make->modal = $getmodal;
        }
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getMake);
        
		$response = Response::json($result);
        return $response;        
    }
    
    /**
     * Function name : bodytypeList
     * Task : Get all body_type List
     * Auther : Sulekha Kumari
     */
    
    public function bodytypeList() {
        
        $getBodyType =DB::table('body_type')->select('id','body_type')->orderBy('id', 'DESC')->get();
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getBodyType);
        
		$response = Response::json($result);
        return $response;        
    }
    
    /**
     * Function name : bodytypeList
     * Task : Get all bodytypeList of modal
     * Auther : Sulekha Kumari
     */
    
    public function bodytypeListbymodal(Request $request){
        $model_id = $request['model_id'];
        
        // get all body_type according to modal id..
        $getBodyType =DB::table('body_type')->where('model_id', $model_id)->select('id','body_type')->orderBy('id', 'DESC')->get();
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getBodyType);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : modalList
     * Task : Get all modal list of companies/make
     * Auther : Sulekha Kumari
     */
    
    public function modalList(Request $request){
        $make_id = $request['make_id'];
        
        // get all states according to country id..
        $getmodal =DB::table('car_models')->where('make', $make_id)->select('id','title','trim')->orderBy('id', 'DESC')->get();
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getmodal);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : transmissionList
     * Task : Get all transmission List
     * Auther : Sulekha Kumari
     */
    
    public function transmissionList() {
        
        $getTransmissionType =DB::table('transmission')->select('id','transmission')->orderBy('id', 'DESC')->get();
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getTransmissionType);
        
		$response = Response::json($result);
        return $response;        
    }
    
    /**
     * Function name : vehicleTypesList
     * Task : Get all vehicleTypes List
     * Auther : Sulekha Kumari
     */
    
    public function vehicleTypesList() {
        
        $getVehicleType =DB::table('vehicle_types')->select('id','type')->orderBy('id', 'ASC')->get();
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getVehicleType);
        
		$response = Response::json($result);
        return $response;        
    }
    
   
    
    
    
    /**
     * Function name : customerRegister
     * Task : Normal user registration.
     * Auther : Sulekha Kumari
     */
    
   
    
    /**
     * Function name : socialRegistration
     * Task : Social Registration
     * Auther : Sulekha Kumari
     */
    
    public function socialRegistration(Request $request)
    {
        //facebook - phone and email and social_id
        //google - email and social_id
        $first_name=$request->first_name;
		$last_name=$request->last_name;
		$email=$request->email;
//		$password=$request->password;
        $country_code=$request->country_code;
        $phone_no=$request->phone_no;
		$flat_no=$request->flat_no;
		$country_id=$request->country_id;
		$state_id=$request->state_id;
		$city_id=$request->city_id;
		$device_id=$request->device_id;
		$social_id=$request->social_id;
//		$social_type=$request->social_type;
        
        

		if(!isset($first_name)){
			$result=array("code" => 201 , "success" => "false" , "message" => "First Name is required.");
		}else if(!isset($last_name)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Last Name is required.");
		}else if(!isset($email)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Valid Email is required.");
		}else if(!isset($phone_no)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Phone is required.");
        }else if(!isset($country_code)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Country Code is required.");
		}else if(!isset($flat_no)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Flat No is required.");
		}else if(!isset($country_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Country is required.");
		}else if(!isset($state_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "State is required.");
		}else if(!isset($city_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "City is required.");
		}else if(!isset($device_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Device Id is required.");
		}else if(!isset($social_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Social Id is required.");
		}else{
			$date = date("Y-m-d H:i:s", time());
            $user1 = DB::table('users')->where('social_id',$social_id)->select('email','phone_no','social_id')->first();
            
            $user2 = DB::table('users')->where('email',$email)->select('email','phone_no','social_id')->first();
            
            $user3 = DB::table('users')->where('phone_no',$phone_no)->select('email','phone_no','social_id')->first();
            
            if($user1 && $user1->social_id==$social_id)
            {
				$result=array("code" => 201 , "success" => "false" , "message" => "Social ID already exists, please try another.");
            }else if($user2 && $user2->email==$email)
            {
                $result=array("code" => 201 , "success" => "false" , "message" => "Email already exists, please try another.");
            }else if($user3 && $user3->phone_no==$phone_no)
            {
                $result=array("code" => 201 , "success" => "false" , "message" => "Phone already exists, please try another.");
            }else
            {
                $data = [
                    'user_type'  => 'Customer',
                    'first_name' => trim($first_name),
                    'last_name'  => trim($last_name),
                    'name'       => trim($first_name.' '.$last_name),
                    'email'      => trim($email),
                    //'password'   => md5(trim($password)), 
                    'phone_no'   => trim($phone_no),
                    'country_code'   => trim($country_code),
                    'flat_no'    => trim($flat_no),
                    'city_id'    => trim($city_id),
                    'state_id'   => trim($state_id),
                    'country_id' => trim($country_id),
                    'device_id'  => trim($device_id),
                    'social_id'  => trim($social_id),
                    'status'  => 'Active',
                ];
                $adduser =DB::table('users')->insert($data);
                if($adduser){
                    $result=array("code" => 200 , "success" => "true" , "message" => "User added successfully.");
                    
                    
                    $userInfo = DB::table('users')->where('social_id',$social_id)->first();
                
                    $ssltoken = openssl_random_pseudo_bytes(30);
                    $remember_token = bin2hex($ssltoken);
                    $update =DB::table('users')->where('id', $userInfo->id)->update(['remember_token'=>$remember_token , 'device_id'=>$device_id]);
                    $userInfo->remember_token = $remember_token;

                    if($userInfo->country_id != 0) {
                        $countryInfo = DB::table('countries')->select(['countries.name as country_name'])->where('id', $userInfo->country_id)->first();     
                        $userInfo->country_name = $countryInfo->country_name;
                    }

                    if($userInfo->state_id != 0) {
                        $countryInfo = DB::table('states')->select(['states.name as state_name'])->where('id', $userInfo->state_id)->first();     
                        $userInfo->state_name = $countryInfo->state_name;
                    }                

                    $result=array("code" => 200 , "success" => "true" , "message" => "Login Successful." , "data" => $userInfo);


                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }	
		}        
        $response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : checksocialRegistration
     * Task : check social Registration
     * Auther : Sulekha Kumari
     */
    
    public function checksocialRegistration(Request $request)
    {
//		$email=$request->email;
		$social_id=$request->social_id;
		$device_id=$request->device_id;
        

		if(!isset($social_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Social ID is required.");
		}else{
			$date = date("Y-m-d H:i:s", time());
            
            $user = DB::table('users')->where('social_id',$social_id)->select('email','social_id')->first();
            if($user && $user->social_id==$social_id)
            {
//				$result=array("code" => 201 , "success" => "false" , "message" => "User already exists, Please Login");
                
                $userInfo = DB::table('users')->where('social_id',$social_id)->first();
                
                $ssltoken = openssl_random_pseudo_bytes(30);
                $remember_token = bin2hex($ssltoken);
                $update =DB::table('users')->where('id', $userInfo->id)->update(['remember_token'=>$remember_token , 'device_id'=>$device_id]);
                $userInfo->remember_token = $remember_token;
                
                if($userInfo->country_id != 0) {
                    $countryInfo = DB::table('countries')->select(['countries.name as country_name'])->where('id', $userInfo->country_id)->first();     
                    $userInfo->country_name = $countryInfo->country_name;
                }
                
                if($userInfo->state_id != 0) {
                    $countryInfo = DB::table('states')->select(['states.name as state_name'])->where('id', $userInfo->state_id)->first();     
                    $userInfo->state_name = $countryInfo->state_name;
                }                
                
                $result=array("code" => 200 , "success" => "true" , "message" => "Login Successful." , "data" => $userInfo);
                
                
                
            }else
            {
                $result=array("code" => 200 , "success" => "true" , "message" => "Proceed to register");
            }	
		}        
        $response = Response::json($result);
        return $response;
    }
    
    
    //$value = Request::header('Content-Type');
    
    public function dealerRegister(Request $request)
    {       
        $first_name=$request->first_name;
		$last_name=$request->last_name;
		$email=$request->email;
		$password=$request->password;
        $country_code=$request->country_code;
        $phone_no=$request->phone_no;
		$flat_no=$request->flat_no;
		$country_id=$request->country_id;
		$state_id=$request->state_id;
		$city_id=$request->city_id;
		$device_id=$request->device_id;
		$company_name=$request->company_name;
        $file = $request->file('company_doc');        

		if(!isset($first_name)){
			$result=array("code" => 201 , "success" => "false" , "message" => "First Name is required.");
		}else if(!isset($last_name)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Last Name is required.");
		}else if(!isset($email)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Valid Email is required.");
		}else if(!isset($password)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Password is required.");
		}else if(!isset($phone_no)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Phone is required.");
        }else if(!isset($country_code)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Country Code is required.");
		}else if(!isset($flat_no)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Flat No is required.");
		}else if(!isset($country_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Country is required.");
		}else if(!isset($state_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "State is required.");
		}else if(!isset($city_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "City is required.");
		}else if(!isset($device_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Device Id is required.");
		}else if(!isset($company_name)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Company Name is required.");
		}else if(!$file || $file == ''){
			$result=array("code" => 201 , "success" => "false" , "message" => "Company Doc is required.");
		}else{
			$date = date("Y-m-d H:i:s", time());
            $user = DB::table('users')->where('email',$email)->whereOr('phone_no',$phone_no)->select('email','phone_no')->first();
            if($user && $user->email==$email)
            {
				$result=array("code" => 201 , "success" => "false" , "message" => "Email already exists, please try another.");
            }else if($user && $user->phone_no==$phone_no)
            {
                $result=array("code" => 201 , "success" => "false" , "message" => "Phone already exists, please try another.");
            }else
            {
                $data = [
                    'user_type'  => 'Dealer',
                    'first_name' => trim($first_name),
                    'last_name'  => trim($last_name),
                    'name'       => trim($first_name.' '.$last_name),
                    'email'      => trim($email),
                    'password'   => md5(trim($password)), 
                    'phone_no'   => trim($phone_no),
                    'flat_no'    => trim($flat_no),
                    'city_id'    => trim($city_id),
                    'state_id'   => trim($state_id),
                    'country_id' => trim($country_id),
                    'device_id'  => trim($device_id),
					'status'  => 'Inactive'
                ];
                $adduser =DB::table('users')->insert($data);
                
                if($adduser){
                    
                    $userInfo = DB::table('users')->where('email', $email)->first();
                    
                    $uploaded_multiple = $request->file('company_doc');
                    $fileName = '';
                    foreach($uploaded_multiple as $uploaded_single){
                        // $newFileName = rand().'.'.$uploaded_single->getClientOriginalExtension();
                        
                        $extension = $uploaded_single->getClientOriginalExtension();
                        $newFileName = rand().getUniqueName($extension);
                        $storePath = public_path('/uploads/dealer_documents');
                        $uploaded_single->move($storePath,$newFileName);
                        $fileName = $fileName.$newFileName.',';
                    }
                    $company_doc = $fileName;
                    
                    $data_dealer = [
                        'dealer_id'    =>  $userInfo->id,
                        'company_name' =>  trim($company_name),
                        'company_doc' => $company_doc,
                        'is_approved' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $adddealer =DB::table('dealer_other_info')->insert($data_dealer);
                    
                    
                    $result=array("code" => 200 , "success" => "true" , "message" => "Dealer added successfully." , "data_dealer" => $data_dealer);
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }	
		}        
        $response = Response::json($result);
        return $response;
    }
    
    
    public function testfileupload(Request $request)
    {
        /* single file upload */
        $uploaded_single = $request->file('profile');
        if($request->hasFile('profile')){
            $new_name = rand().'.'.$uploaded_single->getClientOriginalExtension();
            $uploaded_single->move(public_path('/uploads/images'),$new_name);
            //return response()->json($new_name);
        }else{
            return response()->json('image null');
        }
        
        /* multiple file upload please add [] in postman key */
        $uploaded_multiple = $request->file('image');
        $imageName = '';
        foreach($uploaded_multiple as $uploaded_single){
            $new_name = rand().'.'.$uploaded_single->getClientOriginalExtension();
            $uploaded_single->move(public_path('/uploads/images'),$new_name);
            $imageName = $imageName.$new_name.",";
        }
        $imagedb = $imageName;
        return response()->json($imagedb);
        
        
//        return ["test api"];
    }
    
    
   
    
    /**
     * Function name : login
     * Task : Normal user login.
     * Auther : Sulekha Kumari
     */
    
    
    
    /**
     * Function name : authenticate_user
     * Task : Check user access token.
     * Auther : Sulekha Kumari
     */
    
    public function authenticate_user($access_token , $user_id)
    {
        $userInfo = DB::table('users')->select(['users.remember_token'])->where('id', $user_id)->first();     
        $db_token = $userInfo->remember_token;
        
        if($db_token == $access_token)
        {
            return true;
        }
        else
        {
            $result=array("code" => 401 , "success" => "false" , "message" => "User Not Authenticated");
            $response = Response::json($result);
            return $result;
        }
    }
    
    public function carPost(Request $request)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_type=$request->car_type;
        $vehicle_type=$request->vehicle_type;
        $make=$request->make;
        $model=$request->model;
        $year=$request->year;
        $registration_number=$request->registration_number;
//        $current_mileage=$request->current_mileage;
        $current_mileage=0;
        $user_type=$request->user_type;
        $sold_notification='no';
        $status='Inactive';
        
		if(!isset($car_type)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car Type is required.");
//		}else if(!isset($vehicle_type)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Vehicle Type is required.");
		}else if(!isset($make)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Make is required.");
		}else if(!isset($model)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Model is required.");
//		}else if(!isset($year)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Year is required.");
		}else if(!isset($registration_number)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Registration No is required.");
		}else if(!isset($current_mileage)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Mileage is required.");
		}else if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "User ID is required.");
		}else if(!isset($user_type)){
			$result=array("code" => 201 , "success" => "false" , "message" => "User Type is required.");
		}else{
            if($vehicle_type == ''){$vehicle_type = 0;}
            if($current_mileage == ''){$current_mileage = 0;}
			
                $data = [
                    'car_type'              => trim($car_type),
                    'vehicle_type'          => trim($vehicle_type),
                    'make'                  => trim($make),
                    'model'                 => trim($model),
                    'year'                  => trim($year),
                    'registration_number'   => trim($registration_number),
                    'current_mileage'       => trim($current_mileage),
                    'user_id'               => trim($user_id),
                    'user_type'             => trim($user_type),
                    'sold_notification'     => trim($sold_notification),
                    'status'                => trim($status),
                    'created_at'            => date('Y-m-d H:i:s'),
                    'updated_at'            => date('Y-m-d H:i:s'),
                ];
                $addcarpostid =DB::table('cars')->insertGetId($data);
                if($addcarpostid){
                    $carInfo = DB::table('cars')->where('id', $addcarpostid)->first();
                    $result=array("code" => 200 , "success" => "true" , "message" => "Car added successfully." , "car_id" => $addcarpostid , "car_details" => $carInfo);
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            	
		}        
        $response = Response::json($result);
        return $response;
    }
    
    public function carPost2(Request $request)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        //`car_id`, `trim`, `transmission`, `no_of_doors`, `seating_capacity`, `body_type`, `color`, `price`, `features`, `previous_owners_number`, `driven_km`, `seller_comment`, `reason_sell`, `condition`, `images`, `date`
        
        $car_id=$request->car_id;
        $trim=$request->trim_id;
        $transmission=$request->transmission;
        $no_of_doors=$request->no_of_doors;
        $seating_capacity=$request->seating_capacity;
        $body_type=$request->body_type;
        $color=$request->color;
        $price=$request->price;
        $features=$request->features;
        $previous_owners_number=$request->previous_owners_number;
        $driven_km=$request->driven_km;
        $seller_comment=$request->seller_comment;
        $reason_sell=$request->reason_sell;
        $condition=$request->condition;
        $file = $request->file('images'); 
//        $file2 = $request->hasFile('thumbImg');
        $fuel_type=$request->fuel_type;
        //$transmission_type=$request->transmission_type;
        
        $engine_capacity=$request->engine_capacity;
        
        $vehicle_summery=$request->vehicle_summery ? $request->vehicle_summery : '';
        
        $vehicle_summery_history=$request->vehicle_summery_history ? $request->vehicle_summery_history : '';
        $vehicle_summery_total_owner=$request->vehicle_summery_total_owner ? $request->vehicle_summery_total_owner : '';
        $vehicle_summery_insurance_type=$request->vehicle_summery_insurance_type ? $request->vehicle_summery_insurance_type : '';
        $vehicle_summery_insurance_upto=$request->vehicle_summery_insurance_upto ? $request->vehicle_summery_insurance_upto : '';
        $vehicle_summery_manuf_warranty=$request->vehicle_summery_manuf_warranty ? $request->vehicle_summery_manuf_warranty : '';
        $vehicle_summery_manuf_warranty_exp=$request->vehicle_summery_manuf_warranty_exp ? $request->vehicle_summery_manuf_warranty_exp : '';
        
        $boost_key = $request->boost_key;
        if($boost_key != '0'){
            $r_from_date = $request->from_date;
            $r_to_date = $request->to_date;
            $from_date= date("Y-m-d", strtotime($request->from_date));
            $to_date= date("Y-m-d", strtotime($request->to_date));
            $requested_price= $request->requested_price;
            $payment_id = rand();
            $payment_mode = 'stripe';
            $status = 'success';
            $boost_post_type = 'promotion';
            $currency = 'USD';
            $submit_date= date("Y-m-d");
        }
        
        $inspection_key = $request->inspection_key;
        if($inspection_key != '0'){
            $inspection_address=$request->inspection_address;
            $inspection_date1=$request->inspection_date;
            $inspection_date= date("Y-m-d", strtotime($request->inspection_date));
            $inspection_payment_id = rand();
            $inspection_payment_method = 'stripe';
            $inspection_status = 'success';
            $inspection_request_for = 'inspection';//'inspection' and 360photo
        }
        
        $photo360_key = $request->photo360_key;
        if($photo360_key != '0'){
            $photo360_address=$request->photo360_address;
            $photo360_date1=$request->photo360_date;
            $photo360_date= date("Y-m-d", strtotime($request->photo360_date));
            $photo360_payment_id = rand();
            $photo360_payment_method = 'stripe';
            $photo360_status = 'success';
            $photo360_request_for = '360photo';//'inspection' and 360photo
        }
        
		if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car ID is required.");
		}else if(!isset($trim)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Trim is required.");
//		}else if(!isset($transmission)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Transmission is required.");
//		}else if(!isset($no_of_doors)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "No of doors is required.");
//		}else if(!isset($seating_capacity)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Seating Capacity is required.");
//		}else if(!isset($body_type)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Body Type is required.");
//		}else if(!isset($color)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Color is required.");
		}else if(!isset($price)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Price is required.");
//		}else if(!isset($features)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Features is required.");
//		}else if(!isset($previous_owners_number)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Previous Owners Number is required.");
		}else if(!isset($driven_km)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Driven KM is required.");
//		}else if(!isset($seller_comment)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Sellers Comment is required.");
//		}else if(!isset($reason_sell)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Reason For Sell is required.");
//		}else if(!isset($condition)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Condition is required.");
//		}else if(!$file2){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Thumbnail Image are required.");
//		}else if(!$file || $file == ''){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Images are required.");
        }else if($boost_key != '0' && ($r_from_date == '0' ||  $r_from_date == '') ){
			$result=array("code" => 201 , "success" => "false" , "message" => "Boost From Date is required.");
        }else if($boost_key != '0' && ($r_to_date == '0' ||  $r_to_date == '') ){
			$result=array("code" => 201 , "success" => "false" , "message" => "Boost To Date is required.");
        }else if($boost_key != '0' && ($requested_price == '0' ||  $requested_price == '') ){
			$result=array("code" => 201 , "success" => "false" , "message" => "Boost Price is required.");
        }else if($inspection_key != '0' && ($inspection_date1 == '0' ||  $inspection_date1 == '') ){
			$result=array("code" => 201 , "success" => "false" , "message" => "Inspection Date is required.");
        }else if($inspection_key != '0' && ($inspection_address == '0' ||  $inspection_address == '') ){
			$result=array("code" => 201 , "success" => "false" , "message" => "Inspection Address is required.");
        }else if($photo360_key != '0' && ($photo360_date1 == '0' ||  $photo360_date1 == '')  ){
			$result=array("code" => 201 , "success" => "false" , "message" => "360photo Date is required.");
        }else if($photo360_key != '0' && ($photo360_address == '0' ||  $photo360_address == '')  ){
			$result=array("code" => 201 , "success" => "false" , "message" => "360photo Address is required.");
		}else
        {
//            $uploaded_single = $request->file('thumbImg');
//            $thumbimage = '';
//            if($request->hasFile('thumbImg')){
//                // $newFileName = rand().'.'.$uploaded_single->getClientOriginalExtension();
//
//                $extension = $uploaded_single->getClientOriginalExtension();
//                $newFileName1 = rand().getUniqueName($extension);
//                $storePath = public_path('/uploads/cars_images');
//                $uploaded_single->move($storePath,$newFileName1);
//                $thumbimage = $thumbimage.$newFileName1;
//            }else{
//                $thumbimage = '';
//            }
            
            $fileName = '';
            $thumbimage = '';
            if($file){
                $uploaded_multiple = $request->file('images');
                foreach($uploaded_multiple as $uploaded_single){
                    // $newFileName = rand().'.'.$uploaded_single->getClientOriginalExtension();

//                    $extension = $uploaded_single->getClientOriginalExtension();
//                    $extension = pathinfo($uploaded_single, PATHINFO_EXTENSION);
//                    $extension = '.jpg';
                    $extension = $uploaded_single->extension();
//                    $newFileName = rand().getUniqueName($extension);
                    $newFileName = rand().".".$extension;
                    $storePath = public_path('/uploads/cars_images');
                    $uploaded_single->move($storePath,$newFileName);
                    $fileName = $fileName.$newFileName.',';
                }
                
                $images = $fileName;
                if($images){
                    $images_arr = explode (",", $images); 
                    $firstimage = $images_arr[0];
                    $thumbimage = $firstimage;
                }else{
                    $thumbimage = '';
                }
            }else{
                $images = '';
                $thumbimage = '';
            }
            
//            $carInfo = DB::table('cars')->where('id', $car_id)->first();
//            $driven_km = $carInfo->current_mileage;
            if($no_of_doors == ''){$no_of_doors = 0;}
            if($body_type == ''){$body_type = 0;}
            if($fuel_type == ''){$fuel_type = 0;}
            if($transmission == ''){$transmission = 0;}
            if($price == ''){$price = 0;}
            
            $data = [
                'car_id'                    => trim($car_id),
                'trim'                      => trim($trim),
                'transmission'              => trim($transmission),
                'no_of_doors'               => trim($no_of_doors),
                'seating_capacity'          => trim($seating_capacity),
                'body_type'                 => trim($body_type),
                'color'                     => trim($color),
                'price'                     => trim($price),
                'features'                  => trim($features),
                'previous_owners_number'    => trim($previous_owners_number),
                'driven_km'                 => trim($driven_km),
                'seller_comment'            => trim($seller_comment),
                'reason_sell'               => trim($reason_sell),
                'condition'                 => trim($condition),
                'thumbImg'                    => $thumbimage,
                'images'                    => $images,
                'date'                      => date('Y-m-d H:i:s'),
                'fuel_type'                 => trim($fuel_type),
                'transmission_type'         => 'Automatic',
                'vehicle_summery'           => trim($vehicle_summery),
                'history'           => trim($vehicle_summery_history),
                //'vehicle_summery_total_owner'           => trim($vehicle_summery_total_owner),
                'insurance'           => trim($vehicle_summery_insurance_type),
                //'vehicle_summery_insurance_upto'           => trim($vehicle_summery_insurance_upto),
                'mfwarranty'           => trim($vehicle_summery_manuf_warranty),
                'mfwarrantydate'           => trim($vehicle_summery_manuf_warranty_exp),
                'engine_capacity'           => trim($engine_capacity),
            ];
//            print_r($data);exit;
            $addcarpostid =DB::table('cars_meta')->insertGetId($data);
            if($addcarpostid){
                //update current_milegae
                $data222222 = [
                    'current_mileage'       => trim($driven_km),
                ];
                $carpostupdate = DB::table('cars')
                        ->where('id', $car_id)
                        ->update($data222222);
                
                
                //boost request
                if($boost_key != '0'){
                    $created_at = date("Y-m-d H:i:s", time());
                    $posts_request = DB::table('posts_request')->where('user_id',$user_id)->where('car_id',$car_id)->where('post_type',$boost_post_type)->select('id','car_id', 'car_type', 'user_id', 'post_type', 'from_date', 'to_date', 'requested_price', 'amount', 'currency', 'payment_id', 'payment_mode', 'status', 'submit_date', 'created_at')->first();
                    if($posts_request && $posts_request->car_id==$car_id)
                    {
                    }else{
                        //get car_type
                        $carsInfo = DB::table('cars')->select(['cars.car_type as car_type'])->where('id', $car_id)->first();
                        if($carsInfo){
                            $car_type = $carsInfo->car_type;
                        }else{
                            $car_type = 'used_car';
                        }

                        //get amount (price)
                        $carsMetaInfo = DB::table('cars_meta')->select(['cars_meta.price as price'])->where('car_id', $car_id)->first();
                        if($carsMetaInfo){
                            $amount = $carsMetaInfo->price;
                        }else{
                            $amount = 0;
                        }


                        $data = [
                            'user_id' => trim($user_id),
                            'car_id'  => trim($car_id),
                            'car_type'  => trim($car_type),
                            'post_type' => trim($boost_post_type),
                            'from_date' => $from_date,
                            'to_date' => $to_date,
                            'requested_price' => trim($requested_price),
                            'amount' => $amount,
                            'currency' => trim($currency),
                            'payment_id' => trim($payment_id),
                            'payment_mode' => trim($payment_mode),
                            'status' => trim($status),
                            'submit_date' => $submit_date,
                            'created_at' => $created_at
                        ];
                        $save_posts_request =DB::table('posts_request')->insert($data);
                    }
                }
                
                
                //inspection request
                if($inspection_key != '0'){
                    $created_at = date("Y-m-d H:i:s", time());
                    $ins_badges = DB::table('badges')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
                    if($ins_badges && $ins_badges->car_id==$car_id)
                    {
                        //already badge id exist
                        //check for inspection entry in badge_request
                        $ins_badge_id = $ins_badges->id;

                        $ins_badge_request = DB::table('badge_request')->where('badge_id',$ins_badge_id)->where('request_for',$inspection_request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                        if($ins_badge_request && $ins_badge_request->request_for==$inspection_request_for)
                        {
                        }else{
                            $data1 = [
                                'badge_id'=> trim($ins_badge_id),
                                'request_for'=> trim($inspection_request_for),
                                'address'=> trim($inspection_address),
                                'date'=> trim($inspection_date),
                                'payment_id'=> trim($inspection_payment_id),
                                'payment_method'=> trim($inspection_payment_method),
                                'status'=> trim($inspection_status),
                            ];

                            $ins_badge_request_id =DB::table('badge_request')->insertGetId($data1);
                        }
                    }else{
                        $ins_data = [
                            'user_id' => trim($user_id),
                            'car_id'  => trim($car_id),
                            'created_at'  => $created_at,
                            'updated_at'  => $created_at,
                        ];
                        
                        $ins_badge_id =DB::table('badges')->insertGetId($ins_data);
                        if($ins_badge_id)
                        {                            
                            $ins_data1 = [
                                'badge_id'=> trim($ins_badge_id),
                                'request_for'=> trim($inspection_request_for),
                                'address'=> trim($inspection_address),
                                'date'=> trim($inspection_date),
                                'payment_id'=> trim($inspection_payment_id),
                                'payment_method'=> trim($inspection_payment_method),
                                'status'=> trim($inspection_status),
                            ];

                            $ins_badge_request_id =DB::table('badge_request')->insertGetId($ins_data1);
                        }else{
                        }
                    }
                }
                
                
                
                //360photo request
                if($photo360_key != '0'){
                    $created_at = date("Y-m-d H:i:s", time());
                    $pho_badges = DB::table('badges')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
                    if($pho_badges && $pho_badges->car_id==$car_id)
                    {
                        //already badge id exist
                        //check for inspection entry in badge_request
                        $pho_badge_id = $pho_badges->id;

                        $pho_badge_request = DB::table('badge_request')->where('badge_id',$pho_badge_id)->where('request_for',$photo360_request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                        if($pho_badge_request && $pho_badge_request->request_for==$photo360_request_for)
                        {
                        }else{
                            $data1 = [
                                'badge_id'=> trim($pho_badge_id),
                                'request_for'=> trim($photo360_request_for),
                                'address'=> trim($photo360_address),
                                'date'=> trim($photo360_date),
                                'payment_id'=> trim($photo360_payment_id),
                                'payment_method'=> trim($photo360_payment_method),
                                'status'=> trim($photo360_status),
                            ];

                            $pho_badge_request_id =DB::table('badge_request')->insertGetId($data1);
                        }
                    }else{
                        $pho_data = [
                            'user_id' => trim($user_id),
                            'car_id'  => trim($car_id),
                            'created_at'  => $created_at,
                            'updated_at'  => $created_at,
                        ];
                        
                        $pho_badge_id =DB::table('badges')->insertGetId($pho_data);
                        if($pho_badge_id)
                        {
                            $pho_data1 = [
                                'badge_id'=> trim($pho_badge_id),
                                'request_for'=> trim($photo360_request_for),
                                'address'=> trim($photo360_address),
                                'date'=> trim($photo360_date),
                                'payment_id'=> trim($photo360_payment_id),
                                'payment_method'=> trim($photo360_payment_method),
                                'status'=> trim($photo360_status),
                            ];

                            $pho_badge_request_id =DB::table('badge_request')->insertGetId($pho_data1);
                        }else{
                        }
                    }
                }
                
                
                
                $carInfo = DB::table('cars')->where('id', $car_id)->first();
                $carMetaInfo = DB::table('cars_meta')->where('id', $addcarpostid)->first();
                $result=array("code" => 200 , "success" => "true" , "message" => "Car added successfully." , "car_id" => $car_id , "car_details" => $carInfo , "car_details2" => $carMetaInfo);
                
                
                $userInfo = DB::table('users')->where('id', $user_id)->first();
                    //print_r($userInfo);
                $notification_title = "Car Posted Successfully";
                $notification_body = "Car Posted Successfully";
                $notification_tokens_list = array($userInfo->device_id);
                $otherdetails = array();

                $to_user = $user_id;
                $notification_type = 'car_post';
                $relation_id = $car_id;

                $notification_data = [
                        'message' => $notification_title,
                        'message_body'  => $notification_body,
                        'to_user'       => trim($to_user),
                        'notification_type'=>$notification_type,
                        'relation_id'       => $relation_id,
                        'status'       => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                $addnotification =DB::table('notifications')->insert($notification_data);

                if($userInfo->device_id){
                    $this->send_notification($notification_title, $notification_body , $notification_tokens_list , $notification_type , $relation_id , $otherdetails = $otherdetails);
                }
                

            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
            }
            	
		}        
        $response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : HomeRecentCarsList
     * Task : Get all HomeRecentCarsList
     * Auther : Sulekha Kumari
     */
    
    public function HomeRecentCarsList(Request $request){
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
//        $getRecentCars =DB::table('cars')->select('*')->where('status', 'Active')->orderBy('id', 'DESC')->get();
        $getRecentCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("0 as liked") , 'cars_meta.thumbImg' , 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
            ->where('cars.status', 'Active')
            ->where('cars.sold_notification', 'no')
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        
        foreach ($getRecentCars as $getRecentCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getRecentCars1->id;            
            $getRecentCars1->liked = 0;
            if($user_id){
                $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
                if($savedcars && $savedcars->car_id==$car_id)
                {
                    $getRecentCars1->liked = 1;//saved
                }else{
                    $getRecentCars1->liked = 0;//not saved
                }
            }
            
            if($getRecentCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getRecentCars1->thumbImg){
                    $getRecentCars1->thumbImg = $imageUrl.$getRecentCars1->thumbImg;
                }
                if($getRecentCars1->trim){
                    $trim_id = $getRecentCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getRecentCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getRecentCars1->trim_name = "";
                    }
                }else{
                    $getRecentCars1->trim_name = "";
                }
                
                $getRecentCars1->guarantee = 0;//Money back guarantee
                $getRecentCars1->warranty  = 0;//1 month warranty 
                
                $getRecentCars1->inspection = 0;//inspection not requested
                $getRecentCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getRecentCars1->inspection = 1;//inspection requested
                        }else{
                            $getRecentCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getRecentCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getRecentCars1->photo360 = 1;//360photo requested
                        }else{
                            $getRecentCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getRecentCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getRecentCars1->inspection = 0;//inspection not requested
                    $getRecentCars1->photo360 = 0;//360photo not requested
                }
                
                
                $getRecentCars1->boost = 0;//boost not requested
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getRecentCars1->boost = 1;//boost requested
                        $getRecentCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getRecentCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getRecentCars1->boost = 0;//boost not requested
                }
            }
        }
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getRecentCars);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : AllRecentCarsList
     * Task : Get all AllRecentCarsList
     * Auther : Sulekha Kumari
     */
    
    public function AllRecentCarsList(Request $request){
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        

        $getRecentCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
            ->where('cars.status', 'Active')
            ->where('cars.sold_notification', 'no')
            ->where('cars.user_id', $user_id)
            ->orderBy('id', 'DESC')
//            ->limit(5)
            ->get();
        
        foreach ($getRecentCars as $getRecentCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getRecentCars1->id;            
            $getRecentCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getRecentCars1->liked = 1;//saved
            }else{
                $getRecentCars1->liked = 0;//not saved
            }
            
            if($getRecentCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getRecentCars1->thumbImg){
                    $getRecentCars1->thumbImg = $imageUrl.$getRecentCars1->thumbImg;
                }
                if($getRecentCars1->trim){
                    $trim_id = $getRecentCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getRecentCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getRecentCars1->trim_name = "";
                    }
                }else{
                    $getRecentCars1->trim_name = "";
                }
                
                $getRecentCars1->guarantee = 0;//Money back guarantee
                $getRecentCars1->warranty  = 0;//1 month warranty 
                
                $getRecentCars1->inspection = 0;//inspection not requested
                $getRecentCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getRecentCars1->inspection = 1;//inspection requested
                        }else{
                            $getRecentCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getRecentCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getRecentCars1->photo360 = 1;//360photo requested
                        }else{
                            $getRecentCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getRecentCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getRecentCars1->inspection = 0;//inspection not requested
                    $getRecentCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getRecentCars1->boost = 1;//boost requested
                        $getRecentCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getRecentCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getRecentCars1->boost = 0;//boost not requested
                }
            }
        }
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getRecentCars);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : AllRecentCarsListHome
     * Task : Get all AllRecentCarsListHome
     * Auther : Sulekha Kumari
     */
    
    public function AllRecentCarsListHome(Request $request){
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        

        $getRecentCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
            ->where('cars.status', 'Active')
            ->where('cars.sold_notification', 'no')
//            ->where('cars.user_id', $user_id)
            ->orderBy('id', 'DESC')
//            ->limit(5)
            ->get();
        
        foreach ($getRecentCars as $getRecentCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getRecentCars1->id;            
            $getRecentCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getRecentCars1->liked = 1;//saved
            }else{
                $getRecentCars1->liked = 0;//not saved
            }
            
            if($getRecentCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getRecentCars1->thumbImg){
                    $getRecentCars1->thumbImg = $imageUrl.$getRecentCars1->thumbImg;
                }
                if($getRecentCars1->trim){
                    $trim_id = $getRecentCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getRecentCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getRecentCars1->trim_name = "";
                    }
                }else{
                    $getRecentCars1->trim_name = "";
                } 
                
                $getRecentCars1->guarantee = 0;//Money back guarantee
                $getRecentCars1->warranty  = 0;//1 month warranty 
                
                $getRecentCars1->inspection = 0;//inspection not requested
                $getRecentCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getRecentCars1->inspection = 1;//inspection requested
                        }else{
                            $getRecentCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getRecentCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getRecentCars1->photo360 = 1;//360photo requested
                        }else{
                            $getRecentCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getRecentCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getRecentCars1->inspection = 0;//inspection not requested
                    $getRecentCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getRecentCars1->boost = 1;//boost requested
                        $getRecentCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getRecentCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getRecentCars1->boost = 0;//boost not requested
                }
            }
        }
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getRecentCars);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : HomePromotionalCarsList
     * Task : Get all HomePromotionalCarsList
     * Auther : Sulekha Kumari
     */
    
    public function HomePromotionalCarsList(Request $request){
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }

        $todaydate = date("Y-m-d");
        $getRecentCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('posts_request', 'cars.id', '=', 'posts_request.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'posts_request.id as posts_request_id', 'posts_request.from_date', 'posts_request.to_date', 'posts_request.requested_price', 'posts_request.amount', 'posts_request.currency', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
//            ->whereDate('posts_request.from_date', '<=', $todaydate)
//            ->whereDate('posts_request.to_date', '>=', $todaydate)
            ->whereDate('posts_request.to_date', '<=', $todaydate)
            ->whereDate('posts_request.from_date', '>=', $todaydate)
            ->where('posts_request.post_type', 'promotion')
            ->where('cars.status', 'Active')
            ->where('cars.sold_notification', 'no')
            ->where('posts_request.status', 'success')
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        
        foreach ($getRecentCars as $getRecentCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getRecentCars1->id;            
            $getRecentCars1->liked = 0;
            if($user_id){
                $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
                if($savedcars && $savedcars->car_id==$car_id)
                {
                    $getRecentCars1->liked = 1;//saved
                }else{
                    $getRecentCars1->liked = 0;//not saved
                }
            }
            
            if($getRecentCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getRecentCars1->thumbImg){
                    $getRecentCars1->thumbImg = $imageUrl.$getRecentCars1->thumbImg;
                }
                if($getRecentCars1->trim){
                    $trim_id = $getRecentCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getRecentCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getRecentCars1->trim_name = "";
                    }
                }else{
                    $getRecentCars1->trim_name = "";
                }
                
                $getRecentCars1->guarantee = 0;//Money back guarantee
                $getRecentCars1->warranty  = 0;//1 month warranty 
                
                $getRecentCars1->inspection = 0;//inspection not requested
                $getRecentCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getRecentCars1->inspection = 1;//inspection requested
                        }else{
                            $getRecentCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getRecentCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getRecentCars1->photo360 = 1;//360photo requested
                        }else{
                            $getRecentCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getRecentCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getRecentCars1->inspection = 0;//inspection not requested
                    $getRecentCars1->photo360 = 0;//360photo not requested
                }
                
                
                $getRecentCars1->boost = 0;//boost not requested
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getRecentCars1->boost = 1;//boost requested
                        $getRecentCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getRecentCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getRecentCars1->boost = 0;//boost not requested
                }
            }
        }
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getRecentCars);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : AllPromotionalCarsList
     * Task : Get all AllPromotionalCarsList
     * Auther : Sulekha Kumari
     */
    
    public function AllPromotionalCarsList(Request $request){
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        $todaydate = date("Y-m-d");
        $getRecentCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('posts_request', 'cars.id', '=', 'posts_request.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'posts_request.id as posts_request_id', 'posts_request.from_date', 'posts_request.to_date', 'posts_request.requested_price', 'posts_request.amount', 'posts_request.currency', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name'  , 'cars_meta.trim as trim')
//            ->whereDate('posts_request.from_date', '<=', $todaydate)
//            ->whereDate('posts_request.to_date', '>=', $todaydate)
            ->whereDate('posts_request.to_date', '<=', $todaydate)
            ->whereDate('posts_request.from_date', '>=', $todaydate)
            ->where('posts_request.post_type', 'promotion')
            ->where('cars.status', 'Active')
            ->where('cars.sold_notification', 'no')
            ->where('posts_request.status', 'success')
            ->orderBy('id', 'DESC')
//            ->limit(5)
            ->get();
        
        foreach ($getRecentCars as $getRecentCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getRecentCars1->id;            
            $getRecentCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getRecentCars1->liked = 1;//saved
            }else{
                $getRecentCars1->liked = 0;//not saved
            }
            
            if($getRecentCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getRecentCars1->thumbImg){
                    $getRecentCars1->thumbImg = $imageUrl.$getRecentCars1->thumbImg;
                }
                if($getRecentCars1->trim){
                    $trim_id = $getRecentCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getRecentCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getRecentCars1->trim_name = "";
                    }
                }else{
                    $getRecentCars1->trim_name = "";
                }
                
                $getRecentCars1->guarantee = 0;//Money back guarantee
                $getRecentCars1->warranty  = 0;//1 month warranty 
                
                $getRecentCars1->inspection = 0;//inspection not requested
                $getRecentCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getRecentCars1->inspection = 1;//inspection requested
                        }else{
                            $getRecentCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getRecentCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getRecentCars1->photo360 = 1;//360photo requested
                        }else{
                            $getRecentCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getRecentCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getRecentCars1->inspection = 0;//inspection not requested
                    $getRecentCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getRecentCars1->boost = 1;//boost requested
                        $getRecentCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getRecentCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getRecentCars1->boost = 0;//boost not requested
                }
            }
        }
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getRecentCars);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : HomeFeaturedCarsList
     * Task : Get all HomeFeaturedCarsList
     * Auther : Sulekha Kumari
     */
    
    public function HomeFeaturedCarsList(Request $request){
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }

        $todaydate = date("Y-m-d");
        $getRecentCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->join('posts_request', 'cars.id', '=', 'posts_request.car_id')
            ->join('companies', 'cars.make', '=', 'companies.id')
            ->join('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'posts_request.id as posts_request_id', 'posts_request.amount', 'posts_request.currency', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name'  , 'cars_meta.trim as trim')
//            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'posts_request.id as posts_request_id', 'posts_request.amount', 'posts_request.currency', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km', 'cars_meta.seating_capacity', 'body_type.body_type as body_type_name',DB::raw("0 as liked") , 'cars_meta.thumbImg')
            ->where('posts_request.post_type', 'featured')
            ->where('cars.status', 'Active')
            ->where('cars.sold_notification', 'no')
            ->where('posts_request.status', 'success')
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        
        foreach ($getRecentCars as $getRecentCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getRecentCars1->id;            
            $getRecentCars1->liked = 0;
            if($user_id){
                $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
                if($savedcars && $savedcars->car_id==$car_id)
                {
                    $getRecentCars1->liked = 1;//saved
                }else{
                    $getRecentCars1->liked = 0;//not saved
                }
            }
            
            if($getRecentCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getRecentCars1->thumbImg){
                    $getRecentCars1->thumbImg = $imageUrl.$getRecentCars1->thumbImg;
                }
                if($getRecentCars1->trim){
                    $trim_id = $getRecentCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getRecentCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getRecentCars1->trim_name = "";
                    }
                }else{
                    $getRecentCars1->trim_name = "";
                }
                
                $getRecentCars1->guarantee = 0;//Money back guarantee
                $getRecentCars1->warranty  = 0;//1 month warranty 
                
                $getRecentCars1->inspection = 0;//inspection not requested
                $getRecentCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getRecentCars1->inspection = 1;//inspection requested
                        }else{
                            $getRecentCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getRecentCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getRecentCars1->photo360 = 1;//360photo requested
                        }else{
                            $getRecentCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getRecentCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getRecentCars1->inspection = 0;//inspection not requested
                    $getRecentCars1->photo360 = 0;//360photo not requested
                }
                
                $getRecentCars1->boost = 0;//boost not requested
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getRecentCars1->boost = 1;//boost requested
                        $getRecentCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getRecentCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getRecentCars1->boost = 0;//boost not requested
                }
            }
        }
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getRecentCars);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : AllFeaturedCarsList
     * Task : Get all AllFeaturedCarsList
     * Auther : Sulekha Kumari
     */
    
    public function AllFeaturedCarsList(Request $request){
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        $todaydate = date("Y-m-d");
        $getRecentCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('posts_request', 'cars.id', '=', 'posts_request.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('body_type', 'cars_meta.body_type', '=', 'body_type.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'posts_request.id as posts_request_id', 'posts_request.amount', 'posts_request.currency', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km', 'cars_meta.seating_capacity', 'body_type.body_type as body_type_name',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name'  , 'cars_meta.trim as trim')
            ->where('posts_request.post_type', 'featured')
            ->where('cars.status', 'Active')
            ->where('cars.sold_notification', 'no')
            ->where('posts_request.status', 'success')
            ->orderBy('id', 'DESC')
//            ->limit(5)
            ->get();
        
        

        
        foreach ($getRecentCars as $getRecentCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getRecentCars1->id;            
            $getRecentCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getRecentCars1->liked = 1;//saved
            }else{
                $getRecentCars1->liked = 0;//not saved
            }
            
            if($getRecentCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getRecentCars1->thumbImg){
                    $getRecentCars1->thumbImg = $imageUrl.$getRecentCars1->thumbImg;
                }
                if($getRecentCars1->trim){
                    $trim_id = $getRecentCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getRecentCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getRecentCars1->trim_name = "";
                    }
                }else{
                    $getRecentCars1->trim_name = "";
                }
                
                $getRecentCars1->guarantee = 0;//Money back guarantee
                $getRecentCars1->warranty  = 0;//1 month warranty 
                
                $getRecentCars1->inspection = 0;//inspection not requested
                $getRecentCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getRecentCars1->inspection = 1;//inspection requested
                        }else{
                            $getRecentCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getRecentCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getRecentCars1->photo360 = 1;//360photo requested
                        }else{
                            $getRecentCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getRecentCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getRecentCars1->inspection = 0;//inspection not requested
                    $getRecentCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getRecentCars1->boost = 1;//boost requested
                        $getRecentCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getRecentCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getRecentCars1->boost = 0;//boost not requested
                }
            }
        }
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getRecentCars);
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : UsedCarSearchResult
     * Task : Get all UsedCarSearchResult
     * Auther : Sulekha Kumari
     */
    
    public function UsedCarSearchResult(Request $request , $last_id = null)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID'); 
        if($user_id){
            $authenticate_user = $this->authenticate_user($access_token, $user_id);
            if($authenticate_user === true){}else{
                $response = Response::json($authenticate_user, 401);
                return $response;
            }
        }
        
        //$status = $request['status'];
        $make = $request['make'];
        $model = $request['model'];
        $price = (int) $request['price'];
        $transmission = $request['transmission'];
//        $seating_capacity = $request['seating_capacity'];
        $engine_capacity = $request['engine_capacity'];
        $fuel_type = $request['fuel_type'];
        $newadded = $request['newadded'];
        $lowtohigh = $request['lowtohigh'];
        $hightolow = $request['hightolow'];
        $current_mileage = (int) $request['current_mileage'];
        $vehicle_type = $request['vehicle_type'] ? $request['vehicle_type'] : 0;
        
//        "transmission": 2,
//        "seating_capacity": "6",
        //price range 
        //engine capacity range
        //no. of seats (2-44)
        //fuel - any , petrol , diesel , electric , hybrid
        //transmission - any , auto & manual
        
        $UsedCarSearchResult =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'cars_meta.id as cars_meta_id', 'cars_meta.trim', 'cars_meta.transmission', 'cars_meta.no_of_doors', 'cars_meta.engine_capacity', 'cars_meta.fuel_type', 'cars_meta.thumbImg', 'cars_meta.images', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type',   'cars_meta.price as price', 'cars_meta.driven_km as driven_km', 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
            ->where('cars.status', 'Active')->where('cars.sold_notification', 'no');
        if($make != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars.make', $make);
        }
        if($model != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars.model', $model);
        }
//        var_dump($price);
        if($price != '0') 
        {
//             $UsedCarSearchResult = $UsedCarSearchResult
//                 ->where('cars_meta.price', $price);
//            $UsedCarSearchResult = $UsedCarSearchResult->where('price', '>=', $price);
            $UsedCarSearchResult = $UsedCarSearchResult->where('price', '<=', $price);
        }
        if($current_mileage != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('driven_km', '<=', $current_mileage);
        }
        if($transmission != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars_meta.transmission', $transmission);
        }
//        if($seating_capacity != 0) 
//        {
//            $UsedCarSearchResult = $UsedCarSearchResult->where('cars_meta.seating_capacity', $seating_capacity);
//        }
        
        if($engine_capacity != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars_meta.engine_capacity', $engine_capacity);
        }
        
        if($fuel_type != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars_meta.fuel_type', $fuel_type);
        }
        
        if($vehicle_type != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('vehicle_type', $vehicle_type);
        }
        
        if($newadded != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->orderBy('id', 'DESC');
        }
        
        if($lowtohigh != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->orderBy('price', 'ASC');
        }
        
        if($hightolow != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->orderBy('price', 'DESC');
        }
        
        if($newadded == '0' && $lowtohigh == '0' && $hightolow == '0') {
            $UsedCarSearchResult = $UsedCarSearchResult->orderBy('id', 'DESC');
        }
            $UsedCarSearchResult = $UsedCarSearchResult->limit(10);
            $UsedCarSearchResult = $UsedCarSearchResult->get();
        
        $baseUrl    = URL::to('/');
        $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
        
        foreach($UsedCarSearchResult as $UsedCarSearchResult1){
            
            if($UsedCarSearchResult1->thumbImg){
                $UsedCarSearchResult1->thumbImg = $imageUrl.$UsedCarSearchResult1->thumbImg;
            }
            
            if($UsedCarSearchResult1->trim){
                $trim_id = $UsedCarSearchResult1->trim;
                $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                //print_r($trimInfo);
                if($trimInfo){
                    $UsedCarSearchResult1->trim_name = $trimInfo->trim_name;
                }else{
                    $UsedCarSearchResult1->trim_name = "";
                }
            }else{
                $UsedCarSearchResult1->trim_name = "";
            }
            
            
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $UsedCarSearchResult1->id;            
            $UsedCarSearchResult1->liked = 0;
            if($user_id){
                $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
                if($savedcars && $savedcars->car_id==$car_id)
                {
                    $UsedCarSearchResult1->liked = 1;//saved
                }else{
                    $UsedCarSearchResult1->liked = 0;//not saved
                }
            }else{
                $UsedCarSearchResult1->liked = 0;//not saved
            }
            
            
            
            
            
            $UsedCarSearchResult1->images =explode("," , $UsedCarSearchResult1->images);
            
            $finalimages = array();
            foreach($UsedCarSearchResult1->images as $UsedCarSearchResult1images){
                $UsedCarSearchResult1images = $imageUrl.$UsedCarSearchResult1images;
                array_push($finalimages, $UsedCarSearchResult1images);
            }
            
            $UsedCarSearchResult1->images = $finalimages;
            
            
            
            if($UsedCarSearchResult1){
                
                $UsedCarSearchResult1->guarantee = 0;//Money back guarantee
                $UsedCarSearchResult1->warranty  = 0;//1 month warranty 
                
                $UsedCarSearchResult1->inspection = 0;//inspection not requested
                $UsedCarSearchResult1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $UsedCarSearchResult1->inspection = 1;//inspection requested
                        }else{
                            $UsedCarSearchResult1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $UsedCarSearchResult1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $UsedCarSearchResult1->photo360 = 1;//360photo requested
                        }else{
                            $UsedCarSearchResult1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $UsedCarSearchResult1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $UsedCarSearchResult1->inspection = 0;//inspection not requested
                    $UsedCarSearchResult1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $UsedCarSearchResult1->boost = 1;//boost requested
                        $UsedCarSearchResult1->price = $posts_request->requested_price;//boost
                    }else{
                        $UsedCarSearchResult1->boost = 0;//boost not requested
                    }
                }else{
                    $UsedCarSearchResult1->boost = 0;//boost not requested
                }
            }
            
            
            
        }
         
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$UsedCarSearchResult);
        
		$response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : UsedCarSearchResultPaginate
     * Task : Get all UsedCarSearchResultPaginate
     * Auther : Sulekha Kumari
     */
    
    public function UsedCarSearchResultPaginate(Request $request , $last_id = null)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID'); 
        if($user_id){
            $authenticate_user = $this->authenticate_user($access_token, $user_id);
            if($authenticate_user === true){}else{
                $response = Response::json($authenticate_user, 401);
                return $response;
            }
        }
        
        //$status = $request['status'];
        $make = $request['make'];
        $model = $request['model'];
        $price = (int) $request['price'];
        $transmission = $request['transmission'];
//        $seating_capacity = $request['seating_capacity'];
        $engine_capacity = $request['engine_capacity'];
        $fuel_type = $request['fuel_type'];
        $newadded = $request['newadded'];
        $lowtohigh = $request['lowtohigh'];
        $hightolow = $request['hightolow'];
        $current_mileage = (int) $request['current_mileage'];
        $vehicle_type = $request['vehicle_type'] ? $request['vehicle_type'] : 0;
        
//        "transmission": 2,
//        "seating_capacity": "6",
        //price range 
        //engine capacity range
        //no. of seats (2-44)
        //fuel - any , petrol , diesel , electric , hybrid
        //transmission - any , auto & manual
        
        $UsedCarSearchResult =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'cars_meta.id as cars_meta_id', 'cars_meta.trim', 'cars_meta.transmission', 'cars_meta.no_of_doors', 'cars_meta.engine_capacity', 'cars_meta.fuel_type', 'cars_meta.thumbImg', 'cars_meta.images', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type',   'cars_meta.price as price', 'cars_meta.driven_km as driven_km', 'transmission.transmission as transmission_name'  , 'cars_meta.trim as trim')
            ->where('cars.status', 'Active')->where('cars.sold_notification', 'no');
        if($make != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars.make', $make);
        }
        if($model != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars.model', $model);
        }
//        var_dump($price);
        if($price != '0') 
        {
//             $UsedCarSearchResult = $UsedCarSearchResult
//                 ->where('cars_meta.price', $price);
//            $UsedCarSearchResult = $UsedCarSearchResult->where('price', '>=', $price);
            $UsedCarSearchResult = $UsedCarSearchResult->where('price', '<=', $price);
        }
        if($current_mileage != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('driven_km', '<=', $current_mileage);
        }
        if($transmission != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars_meta.transmission', $transmission);
        }
//        if($seating_capacity != 0) 
//        {
//            $UsedCarSearchResult = $UsedCarSearchResult->where('cars_meta.seating_capacity', $seating_capacity);
//        }
        
        if($engine_capacity != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars_meta.engine_capacity', $engine_capacity);
        }
        
        if($fuel_type != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('cars_meta.fuel_type', $fuel_type);
        }
        
        if($vehicle_type != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->where('vehicle_type', $vehicle_type);
        }
        
        if($newadded != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->orderBy('id', 'DESC');
        }
        
        if($lowtohigh != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->orderBy('price', 'ASC');
        }
        
        if($hightolow != '0') 
        {
            $UsedCarSearchResult = $UsedCarSearchResult->orderBy('price', 'DESC');
        }
        
        if($newadded == '0' && $lowtohigh == '0' && $hightolow == '0') {
            $UsedCarSearchResult = $UsedCarSearchResult->orderBy('id', 'DESC');
        }
//            $UsedCarSearchResult = $UsedCarSearchResult->limit(10);
            $UsedCarSearchResult = $UsedCarSearchResult->paginate(10);
        
        $baseUrl    = URL::to('/');
        $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
        
        foreach($UsedCarSearchResult as $UsedCarSearchResult1){
            
            if($UsedCarSearchResult1->thumbImg){
                $UsedCarSearchResult1->thumbImg = $imageUrl.$UsedCarSearchResult1->thumbImg;
            }
            if($UsedCarSearchResult1->trim){
                $trim_id = $UsedCarSearchResult1->trim;
                $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                //print_r($trimInfo);
                if($trimInfo){
                    $UsedCarSearchResult1->trim_name = $trimInfo->trim_name;
                }else{
                    $UsedCarSearchResult1->trim_name = "";
                }
            }else{
                $UsedCarSearchResult1->trim_name = "";
            }
            
            
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $UsedCarSearchResult1->id;            
            $UsedCarSearchResult1->liked = 0;
            if($user_id){
                $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
                if($savedcars && $savedcars->car_id==$car_id)
                {
                    $UsedCarSearchResult1->liked = 1;//saved
                }else{
                    $UsedCarSearchResult1->liked = 0;//not saved
                }
            }else{
                $UsedCarSearchResult1->liked = 0;//not saved
            }
            
            
            
            
            
            $UsedCarSearchResult1->images =explode("," , $UsedCarSearchResult1->images);
            
            $finalimages = array();
            foreach($UsedCarSearchResult1->images as $UsedCarSearchResult1images){
                $UsedCarSearchResult1images = $imageUrl.$UsedCarSearchResult1images;
                array_push($finalimages, $UsedCarSearchResult1images);
            }
            
            $UsedCarSearchResult1->images = $finalimages;
            
            
            
            if($UsedCarSearchResult1){
                
                $UsedCarSearchResult1->guarantee = 0;//Money back guarantee
                $UsedCarSearchResult1->warranty  = 0;//1 month warranty 
                
                $UsedCarSearchResult1->inspection = 0;//inspection not requested
                $UsedCarSearchResult1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $UsedCarSearchResult1->inspection = 1;//inspection requested
                        }else{
                            $UsedCarSearchResult1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $UsedCarSearchResult1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $UsedCarSearchResult1->photo360 = 1;//360photo requested
                        }else{
                            $UsedCarSearchResult1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $UsedCarSearchResult1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $UsedCarSearchResult1->inspection = 0;//inspection not requested
                    $UsedCarSearchResult1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $UsedCarSearchResult1->boost = 1;//boost requested
                        $UsedCarSearchResult1->price = $posts_request->requested_price;//boost
                    }else{
                        $UsedCarSearchResult1->boost = 0;//boost not requested
                    }
                }else{
                    $UsedCarSearchResult1->boost = 0;//boost not requested
                }
            }
            
            
            
        }
//        print_r($UsedCarSearchResult);
         
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$UsedCarSearchResult , 'current_page' => $UsedCarSearchResult->currentPage() , 'lastPage' => $UsedCarSearchResult->lastPage());
        
		$response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : termsOfServices
     * Task : Get all termsOfServices
     * Auther : Sulekha Kumari
     */
    
    public function termsOfServices()
    {       
        $termsOfServices =DB::table('pages')
            ->select('pages.*')
            ->where('pages.id', '1')
            ->orderBy('id', 'DESC')
//            ->limit(10)
            ->get();
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$termsOfServices);
        
		$response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : privacyPolicy
     * Task : Get all privacyPolicy
     * Auther : Sulekha Kumari
     */
    
    public function privacyPolicy()
    {       
        $privacyPolicy =DB::table('pages')
            ->select('pages.*')
            ->where('pages.id', '2')
            ->orderBy('id', 'DESC')
//            ->limit(10)
            ->get();
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$privacyPolicy);
        
		$response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : Dashboard
     * Task : Get Dashboard
     * Auther : Sulekha Kumari
     */
    
    public function Dashboard(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        //featured
        //recent
        
        $baseUrl    = URL::to('/');
        $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
        
        $getFeaturedCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('posts_request', 'cars.id', '=', 'posts_request.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('body_type', 'cars_meta.body_type', '=', 'body_type.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'posts_request.id as posts_request_id', 'posts_request.amount', 'posts_request.currency', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km', 'cars_meta.seating_capacity', 'body_type.body_type as body_type_name', 'cars_meta.thumbImg',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name'  , 'cars_meta.trim as trim')
            ->where('posts_request.post_type', 'featured')
            ->where('cars.status', 'Active')
            ->where('cars.sold_notification', 'no')
            ->where('posts_request.status', 'success')
            ->where('cars.user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->limit(2)
            ->get();
        
        foreach ($getFeaturedCars as $getFeaturedCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getFeaturedCars1->id;            
            $getFeaturedCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getFeaturedCars1->liked = 1;//saved
            }else{
                $getFeaturedCars1->liked = 0;//not saved
            }
            
            if($getFeaturedCars1){
                
                if($getFeaturedCars1->thumbImg){
                    $getFeaturedCars1->thumbImg = $imageUrl.$getFeaturedCars1->thumbImg;
                }
                if($getFeaturedCars1->trim){
                    $trim_id = $getFeaturedCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getFeaturedCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getFeaturedCars1->trim_name = "";
                    }
                }else{
                    $getFeaturedCars1->trim_name = "";
                }
                
                $getFeaturedCars1->guarantee = 0;//Money back guarantee
                $getFeaturedCars1->warranty  = 0;//1 month warranty 
                
                $getFeaturedCars1->inspection = 0;//inspection not requested
                $getFeaturedCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
//                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();
//
//                        if($badge_inspection_report)
//                        {
                            $getFeaturedCars1->inspection = 1;//inspection requested
//                        }else{
//                            $getFeaturedCars1->inspection = 0;//inspection not requested
//                        }
                    }else{
                        $getFeaturedCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
//                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();
//
//                        if($badge_360 && $badge_360->status==$status)
//                        {
                            $getFeaturedCars1->photo360 = 1;//360photo requested
//                        }else{
//                            $getFeaturedCars1->photo360 = 0;//360photo not requested
//                        }
                    }else{
                        $getFeaturedCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getFeaturedCars1->inspection = 0;//inspection not requested
                    $getFeaturedCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getFeaturedCars1->boost = 1;//boost requested
                        $getFeaturedCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getFeaturedCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getFeaturedCars1->boost = 0;//boost not requested
                }
            }
        }
        
        $getRecentCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('body_type', 'cars_meta.body_type', '=', 'body_type.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km', 'cars_meta.seating_capacity', 'body_type.body_type as body_type_name', 'cars_meta.thumbImg', DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
            ->where('cars.status', 'Active')
            ->where('cars.user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->limit(2)
            ->get();
        
        foreach ($getRecentCars as $getRecentCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getRecentCars1->id;            
            $getRecentCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getRecentCars1->liked = 1;//saved
            }else{
                $getRecentCars1->liked = 0;//not saved
            }
            
            if($getRecentCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getRecentCars1->thumbImg){
                    $getRecentCars1->thumbImg = $imageUrl.$getRecentCars1->thumbImg;
                }
                if($getRecentCars1->trim){
                    $trim_id = $getRecentCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getRecentCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getRecentCars1->trim_name = "";
                    }
                }else{
                    $getRecentCars1->trim_name = "";
                }
                
                $getRecentCars1->guarantee = 0;//Money back guarantee
                $getRecentCars1->warranty  = 0;//1 month warranty 
                
                $getRecentCars1->inspection = 0;//inspection not requested
                $getRecentCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
//                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();
//
//                        if($badge_inspection_report)
//                        {
                            $getRecentCars1->inspection = 1;//inspection requested
//                        }else{
//                            $getRecentCars1->inspection = 0;//inspection not requested
//                        }
                    }else{
                        $getRecentCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
//                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();
//
//                        if($badge_360 && $badge_360->status==$status)
//                        {
                            $getRecentCars1->photo360 = 1;//360photo requested
//                        }else{
//                            $getRecentCars1->photo360 = 0;//360photo not requested
//                        }
                    }else{
                        $getRecentCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getRecentCars1->inspection = 0;//inspection not requested
                    $getRecentCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getRecentCars1->boost = 1;//boost requested
                        $getRecentCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getRecentCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getRecentCars1->boost = 0;//boost not requested
                }
            }
        }
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , "featured_cars"=>$getFeaturedCars , "recent_cars" => $getRecentCars );
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : MyPost
     * Task : Get MyPost
     * Auther : Sulekha Kumari
     */
    
    public function MyPost(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $getmypendingCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->join('companies', 'cars.make', '=', 'companies.id')
            ->join('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
            ->where('cars.status', 'Inactive')
            ->where('cars.user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        
        foreach ($getmypendingCars as $getmypendingCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getmypendingCars1->id;            
            $getmypendingCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getmypendingCars1->liked = 1;//saved
            }else{
                $getmypendingCars1->liked = 0;//not saved
            }
            
            if($getmypendingCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getmypendingCars1->thumbImg){
                    $getmypendingCars1->thumbImg = $imageUrl.$getmypendingCars1->thumbImg;
                }
                if($getmypendingCars1->trim){
                    $trim_id = $getmypendingCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getmypendingCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getmypendingCars1->trim_name = "";
                    }
                }else{
                    $getmypendingCars1->trim_name = "";
                } 
                
                $getmypendingCars1->guarantee = 0;//Money back guarantee
                $getmypendingCars1->warranty  = 0;//1 month warranty 
                
                $getmypendingCars1->inspection = 0;//inspection not requested
                $getmypendingCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getmypendingCars1->inspection = 1;//inspection requested
                        }else{
                            $getmypendingCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getmypendingCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getmypendingCars1->photo360 = 1;//360photo requested
                        }else{
                            $getmypendingCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getmypendingCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getmypendingCars1->inspection = 0;//inspection not requested
                    $getmypendingCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getmypendingCars1->boost = 1;//boost requested
                        $getmypendingCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getmypendingCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getmypendingCars1->boost = 0;//boost not requested
                }
            }
        }
        
        $getmyapprovedCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
            ->where('cars.status', 'Active')
            ->where('cars.user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        
        foreach ($getmyapprovedCars as $getmyapprovedCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getmyapprovedCars1->id;            
            $getmyapprovedCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getmyapprovedCars1->liked = 1;//saved
            }else{
                $getmyapprovedCars1->liked = 0;//not saved
            }
            
            if($getmyapprovedCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getmyapprovedCars1->thumbImg){
                    $getmyapprovedCars1->thumbImg = $imageUrl.$getmyapprovedCars1->thumbImg;
                }
                if($getmyapprovedCars1->trim){
                    $trim_id = $getmyapprovedCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getmyapprovedCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getmyapprovedCars1->trim_name = "";
                    }
                }else{
                    $getmyapprovedCars1->trim_name = "";
                }
                
                $getmyapprovedCars1->guarantee = 0;//Money back guarantee
                $getmyapprovedCars1->warranty  = 0;//1 month warranty 
                
                $getmyapprovedCars1->inspection = 0;//inspection not requested
                $getmyapprovedCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getmyapprovedCars1->inspection = 1;//inspection requested
                        }else{
                            $getmyapprovedCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getmyapprovedCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getmyapprovedCars1->photo360 = 1;//360photo requested
                        }else{
                            $getmyapprovedCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getmyapprovedCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getmyapprovedCars1->inspection = 0;//inspection not requested
                    $getmyapprovedCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getmyapprovedCars1->boost = 1;//boost requested
                        $getmyapprovedCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getmyapprovedCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getmyapprovedCars1->boost = 0;//boost not requested
                }
            }
        }
        
        $getmyrejectedCars =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("0 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
            ->where('cars.status', 'Rejected')
            ->where('cars.user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        
        foreach ($getmyrejectedCars as $getmyrejectedCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getmyrejectedCars1->id;            
            $getmyrejectedCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getmyrejectedCars1->liked = 1;//saved
            }else{
                $getmyrejectedCars1->liked = 0;//not saved
            }
            
            if($getmyrejectedCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getmyrejectedCars1->thumbImg){
                    $getmyrejectedCars1->thumbImg = $imageUrl.$getmyrejectedCars1->thumbImg;
                }
                if($getmyrejectedCars1->trim){
                    $trim_id = $getmyrejectedCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getmyrejectedCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getmyrejectedCars1->trim_name = "";
                    }
                }else{
                    $getmyrejectedCars1->trim_name = "";
                } 
                
                $getmyrejectedCars1->guarantee = 0;//Money back guarantee
                $getmyrejectedCars1->warranty  = 0;//1 month warranty 
                
                $getmyrejectedCars1->inspection = 0;//inspection not requested
                $getmyrejectedCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getmyrejectedCars1->inspection = 1;//inspection requested
                        }else{
                            $getmyrejectedCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getmyrejectedCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getmyrejectedCars1->photo360 = 1;//360photo requested
                        }else{
                            $getmyrejectedCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getmyrejectedCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getmyrejectedCars1->inspection = 0;//inspection not requested
                    $getmyrejectedCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getmyrejectedCars1->boost = 1;//boost requested
                        $getmyrejectedCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getmyrejectedCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getmyrejectedCars1->boost = 0;//boost not requested
                }
            }
        }
        
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , "pending"=> $getmypendingCars , "approved" => $getmyapprovedCars  , "rejected" => $getmyrejectedCars );
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : MySavedCars
     * Task : Get MySavedCars
     * Auther : Sulekha Kumari
     */
    
    public function MySavedCars(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $getmysavedusedCars =DB::table('cars')
            ->join('users_saved_cars', 'cars.id', '=', 'users_saved_cars.car_id')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->select('cars.*', 'users_saved_cars.id as saved_id','companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km',DB::raw("1 as liked") , 'cars_meta.thumbImg', 'transmission.transmission as transmission_name' , 'cars_meta.trim as trim')
//            ->where('cars.status', 'Inactive')
            ->where('cars.car_type', 'used_car')
            ->where('users_saved_cars.user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get(); 
        
        foreach ($getmysavedusedCars as $getmyrejectedCars1) {
            $car_id = 0;
            $savedcars = '';
            
            $car_id = $getmyrejectedCars1->id;            
            $getmyrejectedCars1->liked = 0;
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $getmyrejectedCars1->liked = 1;//saved
            }else{
                $getmyrejectedCars1->liked = 0;//not saved
            }
            
            if($getmyrejectedCars1){
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
                
                if($getmyrejectedCars1->thumbImg){
                    $getmyrejectedCars1->thumbImg = $imageUrl.$getmyrejectedCars1->thumbImg;
                }
                if($getmyrejectedCars1->trim){
                    $trim_id = $getmyrejectedCars1->trim;
                    $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                    //print_r($trimInfo);
                    if($trimInfo){
                        $getmyrejectedCars1->trim_name = $trimInfo->trim_name;
                    }else{
                        $getmyrejectedCars1->trim_name = "";
                    }
                }else{
                    $getmyrejectedCars1->trim_name = "";
                }
                
                $getmyrejectedCars1->guarantee = 0;//Money back guarantee
                $getmyrejectedCars1->warranty  = 0;//1 month warranty 
                
                $getmyrejectedCars1->inspection = 0;//inspection not requested
                $getmyrejectedCars1->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $getmyrejectedCars1->inspection = 1;//inspection requested
                        }else{
                            $getmyrejectedCars1->inspection = 0;//inspection not requested
                        }
                    }else{
                        $getmyrejectedCars1->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $getmyrejectedCars1->photo360 = 1;//360photo requested
                        }else{
                            $getmyrejectedCars1->photo360 = 0;//360photo not requested
                        }
                    }else{
                        $getmyrejectedCars1->photo360 = 0;//360photo not requested
                    }
                }else{
                    $getmyrejectedCars1->inspection = 0;//inspection not requested
                    $getmyrejectedCars1->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $getmyrejectedCars1->boost = 1;//boost requested
                        $getmyrejectedCars1->price = $posts_request->requested_price;//boost
                    }else{
                        $getmyrejectedCars1->boost = 0;//boost not requested
                    }
                }else{
                    $getmyrejectedCars1->boost = 0;//boost not requested
                }
            }
        }
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , "new"=> array() , "used" => $getmysavedusedCars  , "rent" => array()  , "auction" => array() );
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : MakeCarSave
     * Task : Get MakeCarSave
     * Auther : Sulekha Kumari
     */
    
    public function MakeCarSave(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        
        if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car Id is required.");
		}else{
			$date = date("Y-m-d H:i:s", time());
            $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($savedcars && $savedcars->car_id==$car_id)
            {
                $savecar = DB::table('users_saved_cars')->where('user_id', $user_id)->where('car_id', $car_id)->delete();
                if($savecar){
                    $result=array("code" => 200 , "success" => "true" , "message" => "Car UnSaved successfully.");
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
//                
//				$result=array("code" => 201 , "success" => "false" , "message" => "Car Already Saved");
            }else{
                $data = [
                    'user_id' => trim($user_id),
                    'car_id'  => trim($car_id),
                ];
                $savecar =DB::table('users_saved_cars')->insert($data);
                if($savecar){
                    $result=array("code" => 200 , "success" => "true" , "message" => "Car Saved successfully.");
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : CarDetails
     * Task : Get CarDetails
     * Auther : Sulekha Kumari
     */
    
    public function CarDetails(Request $request){
        //badges 360photo inspection
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');  
        if($user_id){
            $authenticate_user = $this->authenticate_user($access_token, $user_id);
            if($authenticate_user === true){}else{
                $response = Response::json($authenticate_user, 401);
                return $response;
            }
        }
        
        
        $car_id=$request->car_id;
        
        if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car Id is required.");
		}else{
			$date = date("Y-m-d H:i:s", time());
            
            $UsedCarSearchResult =DB::table('cars')
            ->join('cars_meta', 'cars.id', '=', 'cars_meta.car_id')
            ->leftjoin('companies', 'cars.make', '=', 'companies.id')
            ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
            ->leftjoin('body_type', 'cars_meta.body_type', '=', 'body_type.id')
            ->leftjoin('vehicle_types', 'cars.vehicle_type', '=', 'vehicle_types.id')
            ->leftjoin('fuel_types', 'cars_meta.fuel_type', '=', 'fuel_types.id')
            ->leftjoin('transmission', 'cars_meta.transmission', '=', 'transmission.id')
            ->leftjoin('users', 'cars.user_id', '=', 'users.id')
            ->select('cars.*', 'cars_meta.id as cars_meta_id', 'cars_meta.trim', 'cars_meta.trim as trim_id', 'cars_meta.transmission', 'transmission.transmission as transmission_name', 'cars_meta.no_of_doors', 'cars_meta.seating_capacity', 'cars_meta.thumbImg', 'cars_meta.images', 'companies.title as make_name', 'car_models.title as model_name', 'cars.vehicle_type as vehicle_type', 'cars_meta.price as price', 'cars_meta.driven_km as driven_km','cars_meta.body_type as body_type', 'body_type.body_type as body_type_name', 'vehicle_types.type as vehicle_type_name', 'cars_meta.features as features', 'cars_meta.fuel_type', 'fuel_types.type as fuel_types_name', 'cars_meta.transmission_type', 'cars_meta.vehicle_summery', 'cars_meta.history as vehicle_summery_history', 'cars_meta.insurance as vehicle_summery_insurance_type', 'cars_meta.mfwarranty as vehicle_summery_manuf_warranty', 'cars_meta.mfwarrantydate as vehicle_summery_manuf_warranty_exp', 'cars_meta.engine_capacity', 'cars_meta.color', 'cars_meta.previous_owners_number', 'cars_meta.seller_comment', 'cars_meta.reason_sell', 'cars_meta.condition', 'users.first_name', 'users.last_name', 'users.avatar', 'cars.user_id as receiver_id', 'users.rating' )
            ->where('cars.id',$car_id)
            
            ->first();
            //print_r($UsedCarSearchResult);
        
            $baseUrl    = URL::to('/');
            $imageUrl   = $baseUrl . '/public/uploads/cars_images/';
            ///uploads/profile
            
            if($UsedCarSearchResult->thumbImg != ''){
                $UsedCarSearchResult->thumbImg = $imageUrl.$UsedCarSearchResult->thumbImg;
            }
            if($UsedCarSearchResult->trim){
                $trim_id = $UsedCarSearchResult->trim;
                $trimInfo = DB::table('car_models')->select('id' , 'trim as trim_name')->where('id', $trim_id)->first();
                //print_r($trimInfo);
                if($trimInfo){
                    $UsedCarSearchResult->trim_name = $trimInfo->trim_name;
                }else{
                    $UsedCarSearchResult->trim_name = "";
                }
            }else{
                $UsedCarSearchResult->trim_name = "";
            }
            
            if($UsedCarSearchResult->avatar){
                $imageUrlprofile   = $baseUrl . '/public/uploads/profile/';
                $UsedCarSearchResult->avatar = $imageUrlprofile.$UsedCarSearchResult->avatar;
            }
            
        
            
            $finalimages = array();
            if($UsedCarSearchResult){
                $UsedCarSearchResult->images =explode("," , $UsedCarSearchResult->images);
                
                foreach($UsedCarSearchResult->images as $UsedCarSearchResult1images){
                    if(!empty($UsedCarSearchResult1images)){
                        $UsedCarSearchResult1images = $imageUrl.$UsedCarSearchResult1images;
                        array_push($finalimages, $UsedCarSearchResult1images);
                    }
                    
                }
            
            $UsedCarSearchResult->images = $finalimages;
                
            }
            
            $UsedCarSearchResult->pictures_360 = array();
            $UsedCarSearchResult->pictures_normal = $UsedCarSearchResult->images;
            
            $UsedCarSearchResult->guarantee = 0;//Money back guarantee
            $UsedCarSearchResult->warranty  = 0;//1 month warranty 
            
            if($UsedCarSearchResult){
                $UsedCarSearchResult->inspection = 0;//inspection not requested
                $UsedCarSearchResult->photo360 = 0;//360photo not requested

                $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();

                if($badges && $badges->car_id==$car_id)
                {
                    $request_for = 'inspection';//'inspection' and 360photo
                    $request_for1 = '360photo';//'inspection' and 360photo
                    //already badge id exist
                    //check for inspection entry in badge_request
                    $badge_id = $badges->id;
                    $status = 'success';

                    $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();

                    if($badge_request && $badge_request->request_for==$request_for && $badge_request->status==$status)
                    {
                        $badge_inspection_report = DB::table('badge_inspection_report')->where('badge_id',$badge_id)->select('*')->first();

                        if($badge_inspection_report)
                        {
                            $UsedCarSearchResult->inspection = 1;//inspection requested
                        }else{
                            $UsedCarSearchResult->inspection = 0;//inspection not requested
                        }
                        
                    }else{
                        $UsedCarSearchResult->inspection = 0;//inspection not requested
                    }

                    $badge_request1 = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for1)->select('id','badge_id','request_for','status')->first();

                    if($badge_request1 && $badge_request1->request_for==$request_for1 && $badge_request1->status==$status)
                    {
                        $request_id = $badge_request1->id;
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->where('request_id',$request_id)->select('*')->get();
                        if($badge_360){
                            //public/uploads/360photography
                            foreach($badge_360 as $badgeimage){
                                $badgeimageUrl   = $baseUrl . '/public/uploads/360photography/';
                                $badgeimage->panel = $badgeimageUrl.$badgeimage->panel;
                            }
                            $UsedCarSearchResult->pictures_360 = $badge_360;
                        }else{
                            $UsedCarSearchResult->pictures_360 = array();
                        }
                        
                        $badge_360 = DB::table('badge_360')->where('badge_id',$badge_id)->select('id','badge_id','panel','meta','title','status','uploaded_time')->first();

                        if($badge_360 && $badge_360->status==$status)
                        {
                            $UsedCarSearchResult->photo360 = 1;//360photo requested
                        }else{
                            $UsedCarSearchResult->photo360 = 0;//360photo not requested
                        }
                        
                    }else{
                        $UsedCarSearchResult->photo360 = 0;//360photo not requested
                    }
                }else{
                    $UsedCarSearchResult->inspection = 0;//inspection not requested
                    $UsedCarSearchResult->photo360 = 0;//360photo not requested
                }
                
                $post_type = 'promotion';
                $status = 'success';
                $use_status = 'ongoing';
                $posts_request =DB::table('posts_request')
                    ->where('car_id',$car_id)
                    ->where('post_type',$post_type)
                    ->where('status',$status)
                    ->where('use_status',$use_status)
                    ->select('*')->first();
                if($posts_request && $posts_request->car_id==$car_id && $posts_request->status==$status)
                {
                    $from_date = $posts_request->from_date;
                    $to_date = $posts_request->to_date;

                    
                    $today_date = date('Y-m-d');
                    $today_date=date('Y-m-d', strtotime($today_date));
                    $from_date = date('Y-m-d', strtotime($from_date));
                    $to_date = date('Y-m-d', strtotime($to_date));
    
                    //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                    
                    if (($from_date <= $today_date) && ($today_date <= $to_date)){
                        $UsedCarSearchResult->boost = 1;//boost requested
                        $UsedCarSearchResult->price = $posts_request->requested_price;//boost
                    }else{
                        $UsedCarSearchResult->boost = 0;//boost not requested
                    }
                }else{
                    $UsedCarSearchResult->boost = 0;//boost not requested
                }
            }
            
            
            $finalimages = array();
            if($UsedCarSearchResult->features){
                $features_selected_exp = explode("," , $UsedCarSearchResult->features);
                
//                $people = array("Peter", "Joe", "Glenn", "Cleveland");
//                $fd = "26";
//
//                if (in_array($fd, $features_selected_exp))
//                  {
//                  $UsedCarSearchResult->features_selectedee = "yes";
//                  }
//                else
//                  {
//                  $UsedCarSearchResult->features_selectedee = "no";
//                  }
                
                
                $getFeature =DB::table('features')->select('id','feature')->orderBy('id', 'DESC')->get();
                $final_feature = array();
                
        
                foreach($getFeature as $k => $feature) {
                    $feature_id = 0;
                    $getFeatureChild = '';
                    $feature->parent_id = $feature->id;
                    $parentselected = 0;
                    $feature->parentselected = $parentselected;

                    $feature_id = $feature->id;
                    
                    $getFeatureChild =DB::table('features_child')->where('feature_id', $feature_id)->select('id','child as feature')->orderBy('id', 'DESC')->get();
                    $final_feature_child = array();
                    foreach($getFeatureChild as $j => $featurechild){
                        $child_id = $featurechild->id;
                        if (in_array($child_id, $features_selected_exp))
                          {$selected = 1;}else{$selected = 0;}
                        $featurechild->selected = $selected;
                        if($selected == 0){unset($getFeatureChild[$j]);}
                        if($selected == 1){
                            $parentselected = 1;
                            $final_feature_child[] = $featurechild;
                        }
                    }
                    
                    if($parentselected == 1){$feature->parentselected = $parentselected;}
                     
                    $feature->features_child = $final_feature_child;
//                    $feature->features_child = $getFeatureChild;
                    $feature->id = $feature->id."nn"; 
                    
                    if($parentselected == 0){unset($getFeature[$k]);}
                    if($parentselected == 1){
                        $final_feature[] = $feature;
                    }
                }
                $UsedCarSearchResult->features_selected = $final_feature;
                
            }else{
                $UsedCarSearchResult->features_selected = array();
            }
            
            
            if($user_id){
            
                if($UsedCarSearchResult){
                    $UsedCarSearchResult->liked = 0;
                    $savedcars = DB::table('users_saved_cars')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
                    if($savedcars && $savedcars->car_id==$car_id)
                    {
                        $UsedCarSearchResult->liked = 1;//saved
                    }else{
                        $UsedCarSearchResult->liked = 0;//not saved
                    }
                }
            }else{
                $UsedCarSearchResult->liked = 0;//not saved
            }
            
            if($user_id){
            
                if($UsedCarSearchResult){
                    $UsedCarSearchResult->commented = 0;
                    $commentedcar = DB::table('cars_ratings')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id','car_user_id')->first();
                    if($commentedcar && $commentedcar->car_id==$car_id)
                    {
                        $UsedCarSearchResult->commented = 1;//commented
                    }else{
                        $UsedCarSearchResult->commented = 0;//not commented
                    }
                }
            }else{
                $UsedCarSearchResult->commented = 0;//not commented
            }
            
            if($UsedCarSearchResult){
                                
                $get_total_comments =DB::table('cars_ratings')->where('car_id', $car_id)->select('id','car_id','user_id','date' ,'rating' , 'comment')->orderBy('id', 'DESC')->get();
                $UsedCarSearchResult->total_comments = $get_total_comments;
                foreach($get_total_comments as $get_comment){
//                    print_r($get_comment);
                    $userInfo = DB::table('users')->where('id', $get_comment->user_id)->first();
                    //print_r($userInfo);
                    $get_comment->first_name = $userInfo->first_name;
                    
                    $get_comment->last_name = $userInfo->last_name;

                    $baseUrl    = URL::to('/');
                    $imageUrlprofile   = $baseUrl . '/public/uploads/profile/';
                    if($userInfo->avatar){
                        $get_comment->avatar = $imageUrlprofile.$userInfo->avatar;
                    }else{
                        $get_comment->avatar = "";
                    }
                }
                
            }
            
            
            if($UsedCarSearchResult){
                $UsedCarSearchResult->percent = 0;
                $calculator_percent = DB::table('calculator_percent')->where('id','1')->select('id','percent')->first();
                
                $UsedCarSearchResult->percent = $calculator_percent->percent;//saved
                
                $getcalculator_time =DB::table('calculator_time')->select('id','type','value')->orderBy('id', 'DESC')->get();
                $UsedCarSearchResult->calculator_time = $getcalculator_time;
                
            }
            

         
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$UsedCarSearchResult);
            
            
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    
    
    /**
     * Function name : RequestInspection360
     * Task :  RequestInspection360
     * Auther : Sulekha Kumari
     */
    
    public function RequestInspection360(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        $address=$request->address;
        $inspection_date= date("Y-m-d", strtotime($request->inspection_date));
        $payment_id = rand();
        $payment_method = 'stripe';
        $status = 'success';
        $request_for = $request->request_for;//'inspection' and 360photo
        
        if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car Id is required.");
		}else if(!isset($address)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Address is required.");
		}else if(!isset($inspection_date)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Address is required.");
		}else if(!isset($request_for)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Request Type is required.");
		}else{
			$created_at = date("Y-m-d H:i:s", time());
            $badges = DB::table('badges')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($badges && $badges->car_id==$car_id)
            {
                //already badge id exist
                //check for inspection entry in badge_request
                $badge_id = $badges->id;
                
                $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();
                
                if($badge_request && $badge_request->request_for==$request_for)
                {
                    $result=array("code" => 201 , "success" => "false" , "message" => "Request Already Exists");
                }else{
                    $data1 = [
                        'badge_id'=> trim($badge_id),
                        'request_for'=> trim($request_for),
                        'address'=> trim($address),
                        'date'=> trim($inspection_date),
                        'payment_id'=> trim($payment_id),
                        'payment_method'=> trim($payment_method),
                        'status'=> trim($status),
                    ];
                    
                    $badge_request_id =DB::table('badge_request')->insertGetId($data1);
                    $result=array("code" => 200 , "success" => "false" , "message" => "Requested Successfully");
                }
            }else{
                $data = [
                    'user_id' => trim($user_id),
                    'car_id'  => trim($car_id),
                    'created_at'  => $created_at,
                    'updated_at'  => $created_at,
                ];
//                $savebadge =DB::table('badges')->insert($data);
                $badge_id =DB::table('badges')->insertGetId($data);
                if($badge_id)
                {
                    $data1 = [
                        'badge_id'=> trim($badge_id),
                        'request_for'=> trim($request_for),
                        'address'=> trim($address),
                        'date'=> trim($inspection_date),
                        'payment_id'=> trim($payment_id),
                        'payment_method'=> trim($payment_method),
                        'status'=> trim($status),
                    ];
                    
                    $badge_request_id =DB::table('badge_request')->insertGetId($data1);
                    
                    if($badge_request_id){
                        $result=array("code" => 200 , "success" => "true" , "message" => "Requested Successfully");
                    }else{
                        $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                    }
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : RequestInspection
     * Task :  RequestInspection
     * Auther : Sulekha Kumari
     */
    
    public function RequestBoost(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        $r_from_date = $request->from_date;
        $r_to_date = $request->to_date;
        $from_date1= date("Y-m-d", strtotime($request->from_date));
        $to_date1= date("Y-m-d", strtotime($request->to_date));
        $requested_price= $request->requested_price;
        $payment_id = rand();
        $payment_mode = 'stripe';
        $status = 'success';
        $post_type = 'promotion';
        $currency = 'USD';
        $submit_date= date("Y-m-d");
        
        if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car Id is required.");
		}else if(!isset($r_from_date)){
			$result=array("code" => 201 , "success" => "false" , "message" => "From Date is required.");
		}else if(!isset($r_to_date)){
			$result=array("code" => 201 , "success" => "false" , "message" => "To Date is required.");
		}else if(!isset($requested_price)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Boost Price is required.");
		}else if(!isset($post_type)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Request Type is required.");
		}else{
            //get all posts_request of this car and check date and change use_status
            $post_type = 'promotion';
            $status = 'success';
            $use_status = 'ongoing';
            $allongoingpromotions =DB::table('posts_request')
                ->where('car_id',$car_id)
                ->where('post_type',$post_type)
                ->where('status',$status)
                ->where('use_status',$use_status)
                ->select('*')
            ->get();
//            print_r($allongoingpromotions);
        
            foreach ($allongoingpromotions as $promotionsdata) 
            {
                $promotion_id = 0;
                $promotion_id = $promotionsdata->id;
                $from_date = $promotionsdata->from_date;
                $to_date = $promotionsdata->to_date;
                $today_date = date('Y-m-d');
                $today_date=date('Y-m-d', strtotime($today_date));
                $from_date = date('Y-m-d', strtotime($from_date));
                $to_date = date('Y-m-d', strtotime($to_date));

                //if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
                if (($from_date <= $today_date) && ($today_date <= $to_date)){
                    // echo "ongoing";
                    $updata = ['use_status'=> 'ongoing'];
                }else{
                    //check date for past and future
                    if (($from_date <= $today_date)){
                        // echo "past";
                        $updata = ['use_status'=> 'expired'];
                    }else{
                        // echo "future";
                        $updata = ['use_status'=> 'ongoing'];
                    }
                }
//                print_r($updata);
                $promotionupdate = DB::table('posts_request')
                                ->where('id', $promotion_id)
                                ->update($updata);
            }
            
            //car_type amount
			$created_at = date("Y-m-d H:i:s", time());
//            $posts_request = DB::table('posts_request')->where('user_id',$user_id)->where('car_id',$car_id)->where('post_type',$post_type)->select('id','car_id', 'car_type', 'user_id', 'post_type', 'from_date', 'to_date', 'requested_price', 'amount', 'currency', 'payment_id', 'payment_mode', 'status', 'submit_date', 'created_at')->first();
            
            $post_type = 'promotion';
            $status = 'success';
            $use_status = 'ongoing';
            $posts_request =DB::table('posts_request')
                ->where('car_id',$car_id)
                ->where('post_type',$post_type)
                ->where('status',$status)
                ->where('use_status',$use_status)
                ->select('*')->first();
            if($posts_request && $posts_request->car_id==$car_id)
            {
                $result=array("code" => 201 , "success" => "false" , "message" => "Request Already Exists");
            }else{
                              
                $carsInfo = DB::table('cars')->select(['cars.car_type as car_type'])->where('id', $car_id)->first();
                if($carsInfo){
                    $car_type = $carsInfo->car_type;
                }else{
                    $car_type = 'used_car';
                }

                //get amount (price)
                $carsMetaInfo = DB::table('cars_meta')->select(['cars_meta.price as price'])->where('car_id', $car_id)->first();
                if($carsMetaInfo){
                    $amount = $carsMetaInfo->price;
                }else{
                    $amount = 0;
                }
                
                
                $data = [
                    'user_id' => trim($user_id),
                    'car_id'  => trim($car_id),
                    'car_type'  => trim($car_type),
                    'post_type' => trim($post_type),
                    'from_date' => $from_date1,
                    'to_date' => $to_date1,
                    'requested_price' => trim($requested_price),
                    'amount' => $amount,
                    'currency' => trim($currency),
                    'payment_id' => trim($payment_id),
                    'payment_mode' => trim($payment_mode),
                    'status' => trim($status),
                    'use_status' => trim($use_status),
                    'submit_date' => $submit_date,
                    'created_at' => $created_at
                ];
                $save_posts_request =DB::table('posts_request')->insert($data);
                if($save_posts_request)
                {
                    $result=array("code" => 200 , "success" => "true" , "message" => "Requested Successfully");
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    
    
    
    
    /**
     * Function name : InspectionReport
     * Task :  InspectionReport
     * Auther : Sulekha Kumari
     */
    
    public function InspectionReport(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        $request_for = 'inspection';//'inspection' and 360photo
        
        if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car Id is required.");
		}else if(!isset($request_for)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Request Type is required.");
		}else{
			$created_at = date("Y-m-d H:i:s", time());
//            $badges = DB::table('badges')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            $badges = DB::table('badges')->where('car_id',$car_id)->select('id','user_id','car_id')->first();
            if($badges && $badges->car_id==$car_id)
            {
                //already badge id exist
                //check for inspection entry in badge_request
                $badge_id = $badges->id;
                
                $badge_request = DB::table('badge_request')->where('badge_id',$badge_id)->where('request_for',$request_for)->select('id','badge_id','request_for','address','date','payment_id','payment_method','status')->first();
                
                if($badge_request && $badge_request->request_for==$request_for)
                {                    
                    $request_id = $badge_request->id;
                    
                    $getInspectionReport =
                        DB::table('badge_inspection_report')
                            ->where('badge_id', $badge_id)
//                            ->where('request_id', $request_id)
                            ->select('id','badge_id','request_id','value','date')->orderBy('id', 'asc')->get();
                    
                    if($getInspectionReport){
                        $getInspectionNames =DB::table('inspection_names')->select('id','inspection')->orderBy('id', 'DESC')->get();
        
                        foreach ($getInspectionNames as $getInspectionNamesList) 
                        {
                            $inspection_id = 0;
                            $getOption = '';

                            $inspection_id = $getInspectionNamesList->id;
                            $getOption =DB::table('inspection_options')
                                ->join('badge_inspection_report', 'inspection_options.id', '=', 'badge_inspection_report.inspection_option_id')
                                ->where('badge_inspection_report.badge_id', $badge_id)
                                ->where('inspection_options.inspection_id', $inspection_id)
                                ->select('inspection_options.id','inspection_options.inspection_id','inspection_options.name','badge_inspection_report.value')->orderBy('id', 'asc')->get();
//                            print_r($getOption);
                            $getInspectionNamesList->inspection_options = $getOption;
                        }
                        //get inspect category list and options
                        $result=array("code" => 201 , "success" => "false" , "message" => "Inspection Report Found" , "list" => $getInspectionNames);
                        
                    }else{
                        $result=array("code" => 201 , "success" => "false" , "message" => "No Inspection Report Generated Yet For this Car");
                    }
                    
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "No Inspection Request For this Car Found");
                }
            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "No Inspection Request For this Car Found");
            }
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : fuelTypeList
     * Task :  fuelTypeList
     * Auther : Sulekha Kumari
     */
    
    public function fuelTypeList(){
        $getFuelType =DB::table('fuel_types')->select('id','type')->orderBy('id', 'DESC')->get();
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getFuelType);
        
		$response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : editcarPost
     * Task :  editcarPost
     * Auther : Sulekha Kumari
     */
    
    public function editcarPost(Request $request)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        
        
//        $vehicle_type=$request->vehicle_type;
//        $make=$request->make;
//        $model=$request->model;
//        $year=$request->year;
//        $registration_number=$request->registration_number;
//        $current_mileage=$request->current_mileage;
        
        $vehicle_type=$request->vehicle_type;
        $make=$request->make;
        $model=$request->model;
        $year=$request->year;
        $registration_number=$request->registration_number;
//        $current_mileage=$request->current_mileage;
        $current_mileage=0;
        
        
        $trim=$request->trim_id;
        $transmission=$request->transmission;
        $no_of_doors=$request->no_of_doors;
        $seating_capacity=$request->seating_capacity;
        $body_type=$request->body_type;
        $color=$request->color;
        $price=$request->price;
        $features=$request->features;
        $previous_owners_number=$request->previous_owners_number;
        $driven_km=$request->driven_km;
        $seller_comment=$request->seller_comment;
        $reason_sell=$request->reason_sell;
        $condition=$request->condition;
        $file = $request->file('images'); 
//        $file2 = $request->hasFile('thumbImg');
        $fuel_type=$request->fuel_type;
        //$transmission_type=$request->transmission_type;
        $vehicle_summery=$request->vehicle_summery;
        $engine_capacity=$request->engine_capacity;
        
        
		if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "User ID is required.");
//		}else if(!isset($car_type)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Car Type is required.");
//		}else if(!isset($vehicle_type)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Vehicle Type is required.");
		}else if(!isset($make)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Make is required.");
		}else if(!isset($model)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Model is required.");
//		}else if(!isset($year)){
//			$result=array("code" => 201 , "success" => "false" , "message" => "Year is required.");
		}else if(!isset($registration_number)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Registration No is required.");
		}else if(!isset($price)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Price is required.");
        }else if(!isset($driven_km)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Driven KM is required.");
		}else{
            //check car_id and user_id
            $carsdetails = DB::table('cars')->where('user_id',$user_id)->where('id',$car_id)->select('id','user_id')->first();
            if($carsdetails && $carsdetails->id==$car_id)
            {
                //            $uploaded_single = $request->file('thumbImg');
//            $thumbimage = '';
//            if($request->hasFile('thumbImg')){
//                // $newFileName = rand().'.'.$uploaded_single->getClientOriginalExtension();
//
//                $extension = $uploaded_single->getClientOriginalExtension();
//                $newFileName1 = rand().getUniqueName($extension);
//                $storePath = public_path('/uploads/cars_images');
//                $uploaded_single->move($storePath,$newFileName1);
//                $thumbimage = $thumbimage.$newFileName1;
//            }else{
//                $thumbimage = '';
//            }
            
            $carMetaInfo = DB::table('cars_meta')->where('car_id', $car_id)->first();
            $thumbimage_old = $carMetaInfo->thumbImg;
            $fileName_old = $carMetaInfo->images;
                
            $fileName = '';
            $thumbimage = '';
            if($file){
                $uploaded_multiple = $request->file('images');
                foreach($uploaded_multiple as $uploaded_single){
                    // $newFileName = rand().'.'.$uploaded_single->getClientOriginalExtension();

//                    $extension = $uploaded_single->getClientOriginalExtension();
//                    $extension = pathinfo($uploaded_single, PATHINFO_EXTENSION);
//                    $extension = '.jpg';
                    $extension = $uploaded_single->extension();
//                    $newFileName = rand().getUniqueName($extension);
                    $newFileName = rand().".".$extension;
                    $storePath = public_path('/uploads/cars_images');
                    $uploaded_single->move($storePath,$newFileName);
                    $fileName = $fileName.$newFileName.',';
                }
                
                $images = $fileName;
                if($images){
                    $images_arr = explode (",", $images); 
                    $firstimage = $images_arr[0];
                    $thumbimage = $firstimage;
                }else{
                    $thumbimage = $thumbimage_old;
                }
            }else{
                $images = $fileName_old;
                $thumbimage = $thumbimage_old;
            }        
                if($vehicle_type == ''){$vehicle_type = 0;}
            if($current_mileage == ''){$current_mileage = 0;}
			
            if($no_of_doors == ''){$no_of_doors = 0;}
            if($body_type == ''){$body_type = 0;}
            if($fuel_type == ''){$fuel_type = 0;}
            if($transmission == ''){$transmission = 0;}
            if($price == ''){$price = 0;}
                
                $data = [
//                    'vehicle_type'          => trim($vehicle_type),
//                    'make'                  => trim($make),
//                    'model'                 => trim($model),
//                    'year'                  => trim($year),
//                    'registration_number'   => trim($registration_number),
//                    'current_mileage'       => trim($current_mileage),
                    
                    
                    'vehicle_type'          => trim($vehicle_type),
                    'make'                  => trim($make),
                    'model'                 => trim($model),
                    'year'                  => trim($year),
                    'registration_number'   => trim($registration_number),
                    'current_mileage'       => trim($current_mileage),
                    'updated_at'            => date('Y-m-d H:i:s'),
                ];

                $data2 = [
//                    'trim'                      => trim($trim),
//                    'transmission'              => trim($transmission),
//                    'no_of_doors'               => trim($no_of_doors),
//                    'seating_capacity'          => trim($seating_capacity),
//                    'body_type'                 => trim($body_type),
//                    'color'                     => trim($color),
//                    'price'                     => trim($price),
//                    'features'                  => trim($features),
//                    'previous_owners_number'    => trim($previous_owners_number),
//                    'driven_km'                 => trim($driven_km),
//                    'seller_comment'            => trim($seller_comment),
//                    'reason_sell'               => trim($reason_sell),
//                    'condition'                 => trim($condition),
//                    'fuel_type'                 => trim($fuel_type),
//                    'transmission_type'         => 'Automatic',
//                    'vehicle_summery'           => trim($vehicle_summery),
//                    'engine_capacity'           => trim($engine_capacity),
                    
                    'car_id'                    => trim($car_id),
                    'trim'                      => trim($trim),
                    'transmission'              => trim($transmission),
                    'no_of_doors'               => trim($no_of_doors),
                    'seating_capacity'          => trim($seating_capacity),
                    'body_type'                 => trim($body_type),
                    'color'                     => trim($color),
                    'price'                     => trim($price),
                    'features'                  => trim($features),
                    'previous_owners_number'    => trim($previous_owners_number),
                    'driven_km'                 => trim($driven_km),
                    'seller_comment'            => trim($seller_comment),
                    'reason_sell'               => trim($reason_sell),
                    'condition'                 => trim($condition),
                    'thumbImg'                  => $thumbimage,
                    'images'                    => $images,
                    'date'                      => date('Y-m-d H:i:s'),
                    'fuel_type'                 => trim($fuel_type),
                    'transmission_type'         => 'Automatic',
                    'vehicle_summery'           => trim($vehicle_summery),
                    'engine_capacity'           => trim($engine_capacity),
                ];
                
                try {
                    $carpostupdate = DB::table('cars')
                        ->where('id', $car_id)
                        ->update($data);
                    try {
                        $carpostupdate2 = DB::table('cars_meta')
                            ->where('car_id', $car_id)
                            ->update($data2);
                        
                        $data222222 = [
                            'current_mileage'       => trim($driven_km),
                        ];
                        $carpostupdate = DB::table('cars')
                                ->where('id', $car_id)
                                ->update($data222222);
                        
                        $carInfo = DB::table('cars')->where('id', $car_id)->first();
                        $carMetaInfo = DB::table('cars_meta')->where('car_id', $car_id)->first();
                        $result=array("code" => 200 , "success" => "true" , "message" => "Car Updated successfully." , "car_id" => $car_id , "car_details" => $carInfo , "car_details2" => $carMetaInfo);
                    }  catch (\Exception $ex1) {
                        // dd($ex1);
                        $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                    }
                }  catch (\Exception $ex) {
                    //dd($ex);
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }else{
                // car not of this user
                $result=array("code" => 201 , "success" => "true" , "message" => "Not Authorised To Edit" , "car_id" => $car_id);
                
            }
		}        
        $response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : updateProfile
     * Task :  update-profile
     * Auther : Sulekha Kumari
     */
    
    public function updateProfile(Request $request)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $first_name=$request->first_name;
		$last_name=$request->last_name;
		$email=$request->email;
        $country_code=$request->country_code;
        $phone_no=$request->phone_no;
		$flat_no=$request->flat_no;
		$state_id=$request->state_id;
		$city_id=$request->city_id;  
        
       

		if(!isset($first_name)){
			$result=array("code" => 201 , "success" => "false" , "message" => "First Name is required.");
		}else if(!isset($last_name)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Last Name is required.");
		}else if(!isset($email)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Valid Email is required.");
		}else if(!isset($phone_no)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Phone is required.");
        }else if(!isset($country_code)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Country Code is required.");
		}else if(!isset($flat_no)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Flat No is required.");
		}else if(!isset($state_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "State is required.");
		}else if(!isset($city_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "City is required.");
		}else{
            $user = DB::table('users')->where('id',$user_id)->select('id','email','phone_no')->first();
//            print_r($user);
            if($user)
            {
                $data = [
                    'first_name' => trim($first_name),
                    'last_name'  => trim($last_name),
                    'name'       => trim($first_name.' '.$last_name),
//                    'email'      => trim($email),
                    'phone_no'   => trim($phone_no),
                    'country_code'   =>$country_code,
                    'flat_no'    => trim($flat_no),
                    'city_id'    => trim($city_id),
                    'state_id'   => trim($state_id)
                ];
                
                $updateuser = DB::table('users')
                        ->where('id', $user_id)
                        ->update($data);
                $userInfo = DB::table('users')->where('id', $user_id)->first();
//                if($updateuser){
                    $result=array("code" => 200 , "success" => "true" , "message" => "User Updated successfully." , "user_id" => $user_id , "userInfo" => $userInfo);
//                }else{
//                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.", "user_id" => $user_id , "userInfo" => $userInfo);
//                }
            }	
		}  
                
        $response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : makeOffer
     * Task :  makeOffer
     * Auther : Sulekha Kumari
     */
    
    public function makeOffer(Request $request)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        $offer_price=$request->offer_price;
        
		if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "User ID is required.");
		}else if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car ID is required.");
		}else if(!isset($offer_price)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Offer Price is required.");
		}else{
            $date = date("Y-m-d H:i:s", time());
            
            $getoffers = DB::table('offers')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id')->first();
//            if($getoffers && $getoffers->car_id==$car_id)
//            {
//				$result=array("code" => 201 , "success" => "false" , "message" => "Offer Already Saved");
//            }else{
            
                $data = [
                    'user_id'               => trim($user_id),
                    'car_id'                => trim($car_id),
                    'offer_price'           => trim($offer_price),
                    'offer_status'          => 'Inactive',
                    'created_at'            => $date,
                    'updated_at'            => $date,
                ];

                try {
                    $addoffer = DB::table('offers')->insert($data);

                    $result=array("code" => 200 , "success" => "true" , "message" => "Offer Sent Successfully." , "car_id" => $car_id);
                }  catch (\Exception $ex1) {
                    // dd($ex1);
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
//            }
		}        
        $response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : AskAdmin
     * Task :  AskAdmin
     * Auther : Sulekha Kumari
     */
    
    public function AskAdmin(Request $request)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
            
        $subject=$request->subject;
        $email=$request->email;
        $phone_no=$request->phone_no;
        $message=$request->message;
        
		
            $date = date("Y-m-d H:i:s", time());
//            $data = [
//                    'subject'               => $subject,
//                    'email'                => $email,
//                    'phone_no'                => $phone_no,
//                    'message'               => $message,
//                    'create_date'           => $date,
//                ];
                        
                    
        

//                try {
////                    $addoffer = DB::table('ask_admin')->insert($data);
//                    $createchatmessageentry =DB::table('tickets')->insertGetId($chatmessagedata);
//                    $ticket_id = "tc".$createchatmessageentry;
//                    $chatupdata = ['ticket_id'=> $ticket_id];
//                    $chatdoupdate = DB::table('tickets')
//                                    ->where('id', $createchatmessageentry)
//                                    ->update($chatupdata);
//
//                    $result=array("code" => 200 , "success" => "true" , "message" => "Request Sent Successfully.");
//                }  catch (\Exception $ex1) {
////                     dd($ex1);
//                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
//                }
//            }
        
        $chatmessages = array();
                $chatID = 0;
                $ticketInfo = DB::table('tickets')->where('user_id',$user_id)->first();
                if($ticketInfo){
//                    print_r($ticketInfo);
//                    print_r($ticketInfo->id);
                     //`ticket_id`, `reply`, `from`, `to`, `created_at`
                    $chatmessagedatar = [
                            'ticket_id'                 => $ticketInfo->id,
                            'reply'                       => $message,
                            'from'                       => 'user',
                            'to'                       => 'admin',
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                    $createchatmessageentry =DB::table('tickets_reply')->insertGetId($chatmessagedatar);
                   
                    
                    
                }else{
                    //create new message in ticket
//                    `ticket_id`, `user_id`, `query`, `replied`, `created_at`
                    $chatmessagedata = [
                            'ticket_id'                 => "tc".$chatID,
                            'user_id'                   => $user_id,
                            'query'                       => $message,
                            'replied'                  => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                    $createchatmessageentry =DB::table('tickets')->insertGetId($chatmessagedata);
                    $ticket_id = "tc".$createchatmessageentry;
                    $chatupdata = ['ticket_id'=> $ticket_id];
                    $chatdoupdate = DB::table('tickets')
                                    ->where('id', $createchatmessageentry)
                                    ->update($chatupdata);
                }
        
        $result=array("code" => 200 , "success" => "true" , "message" => "Request Sent Successfully.");
       
        $response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : carCalculator
     * Task : Get carCalculator
     * Auther : Sulekha Kumari
     */
    
    public function carCalculator(){
        $getcalculator =(object) array();
        
        $getcalculator->percent = 0;
        $calculator_percent = DB::table('calculator_percent')->where('id','1')->select('id','percent')->first();

        $getcalculator->percent = $calculator_percent->percent;//saved

        $getcalculator_time =DB::table('calculator_time')->select('id','type','value')->orderBy('id', 'DESC')->get();
        $getcalculator->calculator_time = $getcalculator_time;
                
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getcalculator);
        
		$response = Response::json($result);
        return $response;
    }
    
    
    public function carPostdelete(Request $request)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        
        
		if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car ID is required.");
		}else{
            
            $deletecarpost = DB::table('cars')->where('id', $car_id)->delete();
            if($deletecarpost){
                $deletecarpostmeta = DB::table('cars_meta')->where('car_id', $car_id)->delete();
                $result=array("code" => 200 , "success" => "true" , "message" => "Car deleted successfully.");
            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
            }
            
		}        
        $response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : makeOfferList
     * Task : Get makeOfferList for chat
     * Auther : Sulekha Kumari
     */
    
    public function makeOfferList(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "User ID is required.");
		}else{
            
            // get all states according to country id..
//            $allStates =DB::table('states')->where('country_id', $country_id)->select('id','name')->orderBy('id', 'DESC')->get();
            
            $getoffers = DB::table('offers')
                ->where('offers.user_id',$user_id)
                ->join('cars', 'cars.id', '=', 'offers.car_id')
                ->join('cars_meta', 'cars_meta.car_id', '=', 'offers.car_id')
                ->leftjoin('companies', 'cars.make', '=', 'companies.id')
                ->leftjoin('car_models', 'cars.model', '=', 'car_models.id')
                ->select( 'offers.id' , 'offers.user_id' , 'offers.car_id' , 'offers.offer_price' , 'offers.offer_status' , 'offers.created_at' , 'companies.title as make_name', 'car_models.title as model_name')
                ->get();
//            if($getoffers && $getoffers->car_id==$car_id)
//            {
            $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getoffers);
		} 
        
        
        
		$response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : chatmessagesonmakeoffers
     * Task : Get chatmessagesonmakeoffers
     * Auther : Sulekha Kumari
     */
    
    public function ChatMessagesList(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $offerID=$request->offerID;
        
        if(!isset($offerID)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Offer ID is required.");
		}else{
            
            $chatmessages =DB::table('offers_chat')->where('offerID', $offerID)->select('id','offerID', 'sent_by_ID', 'msg', 'sent_date')->orderBy('id', 'ASC')->get();

            $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$chatmessages);
		} 
        
        
        
		$response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : SendChatMsg
     * Task : Post SendChatMsg
     * Auther : Sulekha Kumari
     */
    
    public function SendChatMsg(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $offerID=$request->offerID;
        $msg=$request->msg;
        
        if(!isset($offerID)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Offer ID is required.");
		}else{
            
            $chat_data = [
                        'offerID'    =>  $offerID,
                        'sent_by_ID' =>  $user_id,
                        'msg' => $msg,
                        'sent_date' => date('Y-m-d H:i:s'),
                    ];
                    $addchat =DB::table('offers_chat')->insert($chat_data);
            
            if($addchat)
            {
                $result=array("code" => 200 , "success" => "true" , "message" => "Message Sent successfully.");
            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
            }
		} 
        
        
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : notificationList
     * Task : Get notificationList
     * Auther : Sulekha Kumari
     */
    
    public function notificationList(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        if(!isset($user_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "User ID is required.");
		}else{
            
            $allNotification =DB::table('notifications')->where('to_user', $user_id)->select('*')->orderBy('id', 'DESC')->get();

            $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$allNotification);
		} 
        
        
        
		$response = Response::json($result);
        return $response;
    }
    
    
    
    /**
     * Function name : UpdateProfileImage
     * Task : Get UpdateProfileImage
     * Auther : Sulekha Kumari
     */
    
    public function UpdateProfileImage(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $date = date("Y-m-d H:i:s", time());
        
        $user = DB::table('users')->where('id',$user_id)->select('id','email','phone_no')->first();
        if($user)
        {
            $uploaded_single = $request->file('avatar');
            if($request->hasFile('avatar')){
                $new_name = rand().'.'.$uploaded_single->getClientOriginalExtension();
                $uploaded_single->move(public_path('/uploads/profile'),$new_name);
                
                
                $update =DB::table('users')->where('id', $user->id)->update(['avatar'=>$new_name]);
                
                $baseUrl    = URL::to('/');
                $imageUrl   = $baseUrl . '/public/uploads/profile/';
                $avatarfile = $imageUrl.$new_name;
                
                $result=array("code" => 200 , "success" => "true" , "message" => "Image Updated successfully." , "avatar" => $avatarfile );
            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
            }
            
        }else{
            $result=array("code" => 201 , "success" => "false" , "message" => "User Not exists");
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : ClientToDealer
     * Task : Get ClientToDealer
     * Auther : Sulekha Kumari
     */
    
    public function ClientToDealer(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $date = date("Y-m-d H:i:s", time());
        $user1 = DB::table('clienttodealer')->where('dealer_id',$user_id)->select('id','dealer_id')->first();
        if(!$user1)
        {
        
            $user = DB::table('users')->where('id',$user_id)->select('id','email','phone_no')->first();
            if($user)
            {
                $uploaded_multiple = $request->file('company_doc');
                $fileName = '';
                foreach($uploaded_multiple as $uploaded_single){
                    // $newFileName = rand().'.'.$uploaded_single->getClientOriginalExtension();

                    $extension = $uploaded_single->getClientOriginalExtension();
                    $newFileName = rand().getUniqueName($extension);
                    $storePath = public_path('/uploads/dealer_documents');
                    $uploaded_single->move($storePath,$newFileName);
                    $fileName = $fileName.$newFileName.',';
                }
                $company_doc = $fileName;
                $company_name = $request->company_name;

                $data_dealer = [
                    'dealer_id'    =>  $user->id,
                    'company_name' =>  trim($company_name),
                    'company_doc' => $company_doc,
                    'is_approved' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $adddealer =DB::table('clienttodealer')->insert($data_dealer);

                $result=array("code" => 200 , "success" => "true" , "message" => "Dealership requested successfully." , "data_dealer" => $data_dealer);

            }else{
                $result=array("code" => 201 , "success" => "false" , "message" => "User Not exists");
            }
        }else{
            $result=array("code" => 201 , "success" => "false" , "message" => "Request Already exists");
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    
    public function ClientCheckDealerRequest(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $date = date("Y-m-d H:i:s", time());
        
        $requestuser = DB::table('clienttodealer')->where('dealer_id',$user_id)->select('*')->first();
        if($requestuser)
        {
  
            $company_doc = explode(",",$requestuser->company_doc);
            $finaldocs = array();
        
        $baseUrl    = URL::to('/');
        $imageUrl   = $baseUrl . '/uploads/dealer_documents';
        
        foreach ($company_doc as $p) {
            if(!empty($p)){
                $p = $imageUrl.$p;
                array_push($finaldocs, $p);
            }
            
        }
            
            
            $requestuser->company_doc = $finaldocs;
            
            
            $result=array("code" => 200 , "success" => "true" , "message" => "Dealership already requested successfully." , "data" => $requestuser);
            
        }else{
            $result=array("code" => 201 , "success" => "false" , "message" => "Dealership Not Requested");
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : makeOffernew_createchat
     * Task :  makeOffernew_createchat
     * Auther : Sulekha Kumari
     */
    
    public function makeOffernew_createchat(Request $request)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $sender_id=$user_id;
        $receiver_id=$request->receiver_id;
        $car_id=$request->car_id;
        $offer_price=$request->offer_price;
        
		if(!isset($receiver_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Receiver ID is required.");
		}else if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car ID is required.");
		}else if(!isset($offer_price)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Offer Price is required.");
		}else{
            $date = date("Y-m-d H:i:s", time());
            
            if($sender_id == $receiver_id){
                $matchThese = ['sender_id' => $sender_id, 'receiver_id' => $receiver_id];
                $checkchatentry = DB::table('users_chat')->where($matchThese)
                ->select('*')
                ->first();
            }else{
                $matchThese = ['sender_id' => $sender_id, 'receiver_id' => $receiver_id];
                $orThose = ['sender_id' => $receiver_id, 'receiver_id' => $sender_id];
                $checkchatentry = DB::table('users_chat')->where($matchThese)
//                ->orWhere($orThose)
                ->select('*')
                ->first();
                if(!$checkchatentry){
                    $checkchatentry = DB::table('users_chat')->where($orThose)
                    ->select('*')
                    ->first();
                }
            } 
            
            if($checkchatentry)
            {
                // create chat message for make offer
                $chatID = $checkchatentry->id;
                try {
                    $chatmessagedata = [
                        'chatID'                    => $chatID,
                        'sent_by_ID'                => $user_id,
                        'msg'                       => '',
                        'is_offer'                  => 1,
                        'car_id'                    => $car_id,
                        'offer_price'               => $offer_price,
                        'sent_date'                 => $date,
                    ];
                    $createchatmessageentry = DB::table('users_chat_msg')->insert($chatmessagedata);
                    
                    $chatupdata = ['updated_at'=> $date];
                    $chatdoupdate = DB::table('users_chat')
                                ->where('id', $chatID)
                                ->update($chatupdata);
                    $result=array("code" => 200 , "success" => "true" , "message" => "Offer Sent Successfully." , "chatID" => $chatID , "sender_id" => $sender_id , "receiver_id" => $receiver_id);
                    
                    $userInfo = DB::table('users')->where('id', $receiver_id)->first();
                    //print_r($userInfo);
                    $notification_title = "Someone Sent Offer On Your Car";
                    $notification_body = "Someone Sent Offer On Your Car";
                    $notification_tokens_list = array($userInfo->device_id);
                    $otherdetails = array();

                    $to_user = $receiver_id;
                    $notification_type = 'make_offer';
                    $relation_id = $sender_id;

                    $notification_data = [
                            'message' => $notification_title,
                            'message_body'  => $notification_body,
                            'to_user'       => trim($to_user),
                            'notification_type'=>$notification_type,
                            'relation_id'       => $relation_id,
                            'status'       => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                    $addnotification =DB::table('notifications')->insert($notification_data);

                    if($userInfo->device_id){
                        $this->send_notification($notification_title, $notification_body , $notification_tokens_list , $notification_type , $relation_id , $otherdetails = $otherdetails);
                    }
                    
                }  catch (\Exception $ex1) {
                    // dd($ex1);
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }else{ 
                //echo "no entry exist";
                // create chat entry and chat message for make offer
                $chatdata = [
                    'sender_id'             => $sender_id,
                    'receiver_id'           => $receiver_id,
                    'created_at'             => $date,
                    'updated_at'             => $date,
                ];
                
                try {
                    $createchatentry =DB::table('users_chat')->insertGetId($chatdata);
                    $chatID = $createchatentry;
                    try {
                        $chatmessagedata = [
                            'chatID'                    => $chatID,
                            'sent_by_ID'                => $user_id,
                            'msg'                       => '',
                            'is_offer'                  => 1,
                            'car_id'                    => $car_id,
                            'offer_price'               => $offer_price,
                            'sent_date'                 => $date,
                        ];
                        $createchatmessageentry = DB::table('users_chat_msg')->insert($chatmessagedata);
                        
                        $chatupdata = ['updated_at'=> $date];
                        $chatdoupdate = DB::table('users_chat')
                                ->where('id', $chatID)
                                ->update($chatupdata);
                        $result=array("code" => 200 , "success" => "true" , "message" => "Offer Sent Successfully." , "chatID" => $chatID , "sender_id" => $sender_id , "receiver_id" => $receiver_id);
                        
                        $userInfo = DB::table('users')->where('id', $receiver_id)->first();
                        //print_r($userInfo);
                        $notification_title = "Someone Sent Offer On Your Car";
                        $notification_body = "Someone Sent Offer On Your Car";
                        $notification_tokens_list = array($userInfo->device_id);
                        $otherdetails = array();

                        $to_user = $receiver_id;
                        $notification_type = 'make_offer';
                        $relation_id = $sender_id;

                        $notification_data = [
                                'message' => $notification_title,
                                'message_body'  => $notification_body,
                                'to_user'       => trim($to_user),
                                'notification_type'=>$notification_type,
                                'relation_id'       => $relation_id,
                                'status'       => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                            ];
                        $addnotification =DB::table('notifications')->insert($notification_data);

                        if($userInfo->device_id){
                            $this->send_notification($notification_title, $notification_body , $notification_tokens_list , $notification_type , $relation_id , $otherdetails = $otherdetails);
                        }
                    }  catch (\Exception $ex1) {
                        // dd($ex1);
                        $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                    }
                }  catch (\Exception $ex) {
                    //dd($ex);
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
                
            }
		}        
        $response = Response::json($result);
        return $response;
    }
    
    
    /**
     * Function name : ChatMessagesListNew
     * Task : Get ChatMessagesListNew
     * Auther : Sulekha Kumari
     */
    
    public function ChatMessagesListNew(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $sender_id=$user_id;
        $receiver_id=$request->receiver_id;
        
        
        
        if(!isset($receiver_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Receiver ID is required.");
		}else{ 
            if($receiver_id == 0){
                $chatmessages = array();
                $chatID = 0;
                $ticketInfo = DB::table('tickets')->where('user_id',$user_id)->first();
                if($ticketInfo){
//                    print_r($ticketInfo);
//                    print_r($ticketInfo->query);
                     
                    $chatmessage =  array(
                        "id" => "N".$ticketInfo->id,
                        "chatID" => $ticketInfo->id,
                        "sent_by_ID" => $user_id,
                        "read_status" => 0,
                        "msg" => $ticketInfo->query,
                        "is_offer" => 0,
                        "car_id" => 0,
                        "offer_price" => 0,
                        "sent_date" => $ticketInfo->created_at
                    );
                    array_push($chatmessages, $chatmessage);
                    //get all message of ticket
                    $ticketInfo = DB::table('tickets_reply')->where('ticket_id',$ticketInfo->id)->get();
                    if($ticketInfo){
                        foreach($ticketInfo as $ticketInfodata){
//                            print_r($ticketInfodata);
//                            print_r($ticketInfodata->reply);
                            if($ticketInfodata->from == 'user'){$sent_by_ID = $user_id;}else{$sent_by_ID = 0;}
                            $chatmessage =  array(
                                "id" => $ticketInfodata->id,
                                "chatID" => $ticketInfodata->id,
                                "sent_by_ID" => $sent_by_ID,
                                "read_status" => 0,
                                "msg" => $ticketInfodata->reply,
                                "is_offer" => 0,
                                "car_id" => 0,
                                "offer_price" => 0,
                                "sent_date" => $ticketInfodata->created_at
                            );
                            array_push($chatmessages, $chatmessage);
                        }
                    }
                    
                    
                }
                
                $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , "chatID" => $chatID ,  "data"=> $chatmessages );
                
            }else{
                    
                
            
                if($sender_id == $receiver_id){
                    $matchThese = ['sender_id' => $sender_id, 'receiver_id' => $receiver_id];
                    $checkchatentry = DB::table('users_chat')->where($matchThese)
                    ->select('*')
                    ->first();
                }else{
                    $matchThese = ['sender_id' => $sender_id, 'receiver_id' => $receiver_id];
                    $orThose = ['sender_id' => $receiver_id, 'receiver_id' => $sender_id];
                    $checkchatentry = DB::table('users_chat')->where($matchThese)
    //                ->orWhere($orThose)
                    ->select('*')
                    ->first();
                    if(!$checkchatentry){
                        $checkchatentry = DB::table('users_chat')->where($orThose)
                        ->select('*')
                        ->first();
                    }
                }

    //            dd($checkchatentry);

                if($checkchatentry)
                {
                    $chatID = $checkchatentry->id;
                    $chatmessages =DB::table('users_chat_msg')->where('chatID', $chatID)->select('*')->orderBy('id', 'ASC')->get();
                    $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , "chatID" => $chatID , "sender_id" => $checkchatentry->sender_id , "receiver_id" => $checkchatentry->receiver_id ,  "data"=> $chatmessages );

                    // make messages read for chat                
                    $chatmsgupdata = ['read_status'=> 1];
                    $chatmsgdoupdate = DB::table('users_chat_msg')
                                    ->where('chatID', $chatID)->where('sent_by_ID', $receiver_id)->where('read_status', 0)
                                    ->update($chatmsgupdata);

                }else{
                    $chatID = 0;
                    $chatmessages = array();
                    $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , "chatID" => $chatID ,  "data"=> $chatmessages );
                }
            }
            
		} 
        
        
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : SendChatMsgNew
     * Task : Post SendChatMsgNew
     * Auther : Sulekha Kumari
     */
    
    public function SendChatMsgNew(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
//        $chatID=$request->chatID;
        $sender_id=$user_id;
        $receiver_id=$request->receiver_id;
        $msg=$request->msg;
        
        if(!isset($receiver_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Receiver ID is required.");
		}else{
            $date = date("Y-m-d H:i:s", time());
            
            if($receiver_id == 0){
                $chatmessages = array();
                $chatID = 0;
                $ticketInfo = DB::table('tickets')->where('user_id',$user_id)->first();
                if($ticketInfo){
//                    print_r($ticketInfo);
//                    print_r($ticketInfo->id);
                     //`ticket_id`, `reply`, `from`, `to`, `created_at`
                    $chatmessagedatar = [
                            'ticket_id'                 => $ticketInfo->id,
                            'reply'                       => $msg,
                            'from'                       => 'user',
                            'to'                       => 'admin',
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                    $createchatmessageentry =DB::table('tickets_reply')->insertGetId($chatmessagedatar);
                   
                    
                    
                }else{
                    //create new message in ticket
//                    `ticket_id`, `user_id`, `query`, `replied`, `created_at`
                    $chatmessagedata = [
                            'ticket_id'                 => "tc".$chatID,
                            'user_id'                   => $user_id,
                            'query'                       => $msg,
                            'replied'                  => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                    $createchatmessageentry =DB::table('tickets')->insertGetId($chatmessagedata);
                    $ticket_id = "tc".$createchatmessageentry;
                    $chatupdata = ['ticket_id'=> $ticket_id];
                    $chatdoupdate = DB::table('tickets')
                                    ->where('id', $createchatmessageentry)
                                    ->update($chatupdata);
                }
                
                $result=array("code" => 200 , "success" => "true" , "message" => "Message Sent successfully." , "chatID" => $chatID , "sender_id" => $sender_id , "receiver_id" => $receiver_id);
                
            }else{
            
                if($sender_id == $receiver_id){
                    $matchThese = ['sender_id' => $sender_id, 'receiver_id' => $receiver_id];
                    $checkchatentry = DB::table('users_chat')->where($matchThese)
                    ->select('*')
                    ->first();
                }else{
                    $matchThese = ['sender_id' => $sender_id, 'receiver_id' => $receiver_id];
                    $orThose = ['sender_id' => $receiver_id, 'receiver_id' => $sender_id];
                    $checkchatentry = DB::table('users_chat')->where($matchThese)
    //                ->orWhere($orThose)
                    ->select('*')
                    ->first();
                    if(!$checkchatentry){
                        $checkchatentry = DB::table('users_chat')->where($orThose)
                        ->select('*')
                        ->first();
                    }
                }

                if($checkchatentry)
                {
                    // create chat message for make offer
                    $chatID = $checkchatentry->id;
                    try {
                        $chatmessagedata = [
                            'chatID'                    => $chatID,
                            'sent_by_ID'                => $user_id,
                            'msg'                       => $msg,
                            'is_offer'                  => 0,
                            'car_id'                    => 0,
                            'offer_price'               => 0,
                            'sent_date' => date('Y-m-d H:i:s'),
                        ];
                        $createchatmessageentry = DB::table('users_chat_msg')->insert($chatmessagedata);

                        $chatupdata = ['updated_at'=> $date];
                        $chatdoupdate = DB::table('users_chat')
                                    ->where('id', $chatID)
                                    ->update($chatupdata);
                        $result=array("code" => 200 , "success" => "true" , "message" => "Message Sent successfully." , "chatID" => $chatID , "sender_id" => $sender_id , "receiver_id" => $receiver_id);

                        $userInfo = DB::table('users')->where('id', $receiver_id)->first();
                        //print_r($userInfo);
                        $notification_title = "New Message in Chat";
                        $notification_body = "New Message in Chat";
                        $notification_tokens_list = array($userInfo->device_id);
                        $otherdetails = array();

                        $to_user = $receiver_id;
                        $notification_type = 'chat';
                        $relation_id = $sender_id;

                        $notification_data = [
                                'message' => $notification_title,
                                'message_body'  => $notification_body,
                                'to_user'       => trim($to_user),
                                'notification_type'=>$notification_type,
                                'relation_id'       => $relation_id,
                                'status'       => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                            ];
                        $addnotification =DB::table('notifications')->insert($notification_data);

                        if($userInfo->device_id){
                            $this->send_notification($notification_title, $notification_body , $notification_tokens_list , $notification_type , $relation_id , $otherdetails = $otherdetails);
                        }

                    }  catch (\Exception $ex1) {
                        // dd($ex1);
                        $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                    }
                }else{ 
                    //echo "no entry exist";
                    // create chat entry and chat message for make offer
                    $chatdata = [
                        'sender_id'             => $sender_id,
                        'receiver_id'           => $receiver_id,
                        'created_at'             => $date,
                        'updated_at'             => $date,
                    ];

                    try {
                        $createchatentry =DB::table('users_chat')->insertGetId($chatdata);
                        $chatID = $createchatentry;
                        try {
                            $chatmessagedata = [
                                'chatID'                    => $chatID,
                                'sent_by_ID'                => $user_id,
                                'msg'                       => $msg,
                                'is_offer'                  => 0,
                                'car_id'                    => 0,
                                'offer_price'               => 0,
                                'sent_date' => date('Y-m-d H:i:s'),
                            ];
                            $createchatmessageentry = DB::table('users_chat_msg')->insert($chatmessagedata);

                            $chatupdata = ['updated_at'=> $date];
                            $chatdoupdate = DB::table('users_chat')
                                    ->where('id', $chatID)
                                    ->update($chatupdata);
                            $result=array("code" => 200 , "success" => "true" , "message" => "Message Sent successfully." , "chatID" => $chatID , "sender_id" => $sender_id , "receiver_id" => $receiver_id);

                            $userInfo = DB::table('users')->where('id', $receiver_id)->first();
                            //print_r($userInfo);
                            $notification_title = "New Message in Chat";
                            $notification_body = "New Message in Chat";
                            $notification_tokens_list = array($userInfo->device_id);
                            $otherdetails = array();

                            $to_user = $receiver_id;
                            $notification_type = 'chat';
                            $relation_id = $sender_id;

                            $notification_data = [
                                    'message' => $notification_title,
                                    'message_body'  => $notification_body,
                                    'to_user'       => trim($to_user),
                                    'notification_type'=>$notification_type,
                                    'relation_id'       => $relation_id,
                                    'status'       => 1,
                                    'created_at' => date('Y-m-d H:i:s'),
                                ];
                            $addnotification =DB::table('notifications')->insert($notification_data);

                            if($userInfo->device_id){
                                $this->send_notification($notification_title, $notification_body , $notification_tokens_list , $notification_type , $relation_id , $otherdetails = $otherdetails);
                            }
                        }  catch (\Exception $ex1) {
                            // dd($ex1);
                            $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                        }
                    }  catch (\Exception $ex) {
                        //dd($ex);
                        $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                    }

                }
            }
		} 
        
        
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : ChatList
     * Task : Get ChatList
     * Auther : Sulekha Kumari
     */
    
    public function ChatList(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
                
        $matchThese = ['sender_id' => $user_id];
        $orThose = ['receiver_id' => $user_id];
        

        $chatlist = DB::table('users_chat')
            ->where($matchThese)
            ->orWhere($orThose)
            ->select('users_chat.id' , 'users_chat.sender_id', 'users_chat.receiver_id', 'users_chat.updated_at')
            ->orderBy('updated_at', 'desc')
            ->get(); 
        
        foreach ($chatlist as $chatlistdata) {
            $chatID = 0;
            $sender_id = 0;
            $receiver_id = 0;            
            
            $chatID = $chatlistdata->id;
            $sender_id = $chatlistdata->sender_id;
            $receiver_id = $chatlistdata->receiver_id;
            if($receiver_id == $user_id){$chatlistdata->receiver_id = $sender_id; $chatlistdata->sender_id = $receiver_id;}
            
            
            $unreadmessages =DB::table('users_chat_msg')->where('chatID', $chatID)->where('sent_by_ID' , '!=', $user_id)->where('read_status', 0)->select('*')->orderBy('id', 'ASC')->get();
            $unreadmessagescount = $unreadmessages->count();
            $chatlistdata->unread_count = $unreadmessagescount;
            
            
            $userInfo = DB::table('users')->where('id',$chatlistdata->receiver_id)->first();
            $chatlistdata->first_name = $userInfo->first_name;
            $chatlistdata->last_name = $userInfo->last_name;
            
            $baseUrl    = URL::to('/');
            $imageUrlprofile   = $baseUrl . '/public/uploads/profile/';
            $chatlistdata->avatar = $imageUrlprofile.$userInfo->avatar;
            
        }
        
        $chatwithadmin =  array(
            "id" => 0,
            "sender_id" => (int) $user_id,
            "receiver_id" => 0,
            "updated_at" =>  date("Y-m-d H:i:s", time()),
            "unread_count" => 0,
            "first_name" => "Super",
            "last_name" => "Admin",
            "avatar" => "https://t3.ftcdn.net/jpg/03/62/56/24/360_F_362562495_Gau0POzcwR8JCfQuikVUTqzMFTo78vkF.jpg"
        );
        $ticketInfo = DB::table('tickets')->where('user_id',$user_id)->first();
//        if($ticketInfo){array_push($chatlist, $chatwithadmin);}
        
        $collection = collect($chatlist);
  
    $collection->push($chatwithadmin);

        
        

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" ,  "data"=> $collection );
	
        
        
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : SubscribeNewsletter
     * Task : Get SubscribeNewsletter
     * Auther : Sulekha Kumari
     */
    
    public function SubscribeNewsletter(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $update =DB::table('users')->where('id', $user_id)->update(['subscribed'=>1]);
        if($update){
            $result=array("code" => 200 , "success" => "true" , "message" => "User subscribed successfully.");
        }else{
            $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : ChangePassword
     * Task : Get ChangePassword
     * Auther : Sulekha Kumari
     */
    
    public function ChangePassword(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        $oldpassword = $request->oldpassword;
        $oldp = md5(trim($oldpassword));
        $newpassword = $request->newpassword;
        $newp = md5(trim($newpassword));
        //'password'   => md5(trim($password))
        
        if(!isset($oldpassword)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Old Password is required.");
		}else if(!isset($newpassword)){
			$result=array("code" => 201 , "success" => "false" , "message" => "New Password is required.");
		}else{
            $user = DB::table('users')->where('id',$user_id)->select('id','email','phone_no','password')->first();
//            print_r($user);
            
            if($user && $user->password==$oldp && $oldpassword != $newpassword)
            {
                $data = [
                    'password' => $newp,
                ];
                
                $updateuser = DB::table('users')
                        ->where('id', $user_id)
                        ->update($data);
                $userInfo = DB::table('users')->where('id', $user_id)->first();
                if($updateuser){
                    $result=array("code" => 200 , "success" => "true" , "message" => "Password Changed successfully." , "user_id" => $user_id , "userInfo" => $userInfo);
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }else{
                if($oldpassword == $newpassword){
                    $result=array("code" => 201 , "success" => "false" , "message" => "Old Password cannot not match New Password");
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Old Password Does not match");
                }
                
            }	
		} 
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : CommentOnCar
     * Task : Get CommentOnCar
     * Auther : Sulekha Kumari
     */
    
    public function CommentOnCar(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        $rating=$request->rating;
        $comment=$request->comment;
        
        if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car Id is required.");
		}else{
           
			$date = date("Y-m-d H:i:s", time());
            $commentedcar = DB::table('cars_ratings')->where('user_id',$user_id)->where('car_id',$car_id)->select('id','user_id','car_id','car_user_id')->first();
            if($commentedcar && $commentedcar->car_id==$car_id)
            {
                $car_user_id = $commentedcar->car_user_id;
                $userInfo = DB::table('users')->where('id', $car_user_id)->first();
                $user_rating = $userInfo->rating; 
                
				$result=array("code" => 201 , "success" => "false" , "message" => "Comment Already Exists" , "car_user_rating" => $user_rating);
            }else{
                $carInfo = DB::table('cars')->where('id', $car_id)->first();
                $car_user_id = $carInfo->user_id;
                $data = [
                    'user_id' => trim($user_id),
                    'car_id'  => trim($car_id),
                    'car_user_id'  => trim($car_user_id),
                    'rating'  => $rating,
                    'comment'  => $comment,
                    'date'  => date('Y-m-d H:i:s'),
                ];
                $commentcar =DB::table('cars_ratings')->insert($data);
                if($commentcar){
                    
                    $allratings = DB::table('cars_ratings')->where('car_user_id',$car_user_id)->selectRaw('sum(rating) as rating_sum,count(rating) as rating_count')->first();
                    //print_r($allratings);
                    if($allratings->rating_count > 0){
                        $total_average = round((($allratings->rating_sum) / ($allratings->rating_count)),1);
                        //print_r($total_average);
                    }else{
                        $total_average = 0;
                    }

                    $update =DB::table('users')->where('id', $car_user_id)->update(['rating'=>$total_average]);

                    $userInfo = DB::table('users')->where('id', $car_user_id)->first();
                    $user_rating = $userInfo->rating; 
                    
                    $result=array("code" => 200 , "success" => "true" , "message" => "Commented successfully." , "car_user_rating" => $user_rating);
                    
                    $userInfo = DB::table('users')->where('id', $car_user_id)->first();
                    //print_r($userInfo);
                    $notification_title = "New Comment / Rating On Your Car";
                    $notification_body = "New Comment / Rating On Your Car";
                    $notification_tokens_list = array($userInfo->device_id);
                    $otherdetails = array();

                    $to_user = $car_user_id;
                    $notification_type = 'comment';
                    $relation_id = $car_id;

                    $notification_data = [
                            'message' => $notification_title,
                            'message_body'  => $notification_body,
                            'to_user'       => trim($to_user),
                            'notification_type'=>$notification_type,
                            'relation_id'       => $relation_id,
                            'status'       => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                    $addnotification =DB::table('notifications')->insert($notification_data);

                    if($userInfo->device_id){
                        $this->send_notification($notification_title, $notification_body , $notification_tokens_list , $notification_type , $relation_id , $otherdetails = $otherdetails);
                    }
                    
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : ReportOnCar
     * Task : Get ReportOnCar
     * Auther : Sulekha Kumari
     */
    
    public function ReportOnCar(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        $report=$request->report;
        
        if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car Id is required.");
		}else{
           
			$date = date("Y-m-d H:i:s", time());
            $carInfo = DB::table('cars')->where('id', $car_id)->first();
            $car_type = $carInfo->car_type;
            
            $reportedcar = DB::table('reports')->where('user_id',$user_id)->where('car_id',$car_id)->select('*')->first();
            if($reportedcar && $reportedcar->car_id==$car_id)
            {
                $user_id = $reportedcar->user_id;
                
                
				$result=array("code" => 201 , "success" => "false" , "message" => "Report Already Exists" );
            }else{
                $carInfo = DB::table('cars')->where('id', $car_id)->first();
                $car_user_id = $carInfo->user_id;
                $data = [
                    'car_id'  => trim($car_id),
                    'user_id' => trim($user_id),
                    'car_type'  => trim($car_type),
                    'report'  => $report,
                    'created_at'  => date('Y-m-d H:i:s'),
                ];
                $commentcar =DB::table('reports')->insert($data);
                if($commentcar){
                    $result=array("code" => 200 , "success" => "true" , "message" => "Reported successfully." );
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : ReportAsSold
     * Task : Get ReportAsSold
     * Auther : Sulekha Kumari
     */
    
    public function ReportAsSold(Request $request){
        
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $car_id=$request->car_id;
        
        
        if(!isset($car_id)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Car Id is required.");
		}else{
           
			$date = date("Y-m-d H:i:s", time());
            $carInfo = DB::table('cars')->where('id', $car_id)->first();
            $car_type = $carInfo->car_type;
            
            if($carInfo && $carInfo->sold_notification=='yes')
            {
                
				$result=array("code" => 201 , "success" => "false" , "message" => "Already Reported As Sold" );
            }else{
                
                $sold_notification='yes';
                $data = [
                    'sold_notification'     => trim($sold_notification),
                    'updated_at'            => date('Y-m-d H:i:s'),
                ];
                $carpostupdate = DB::table('cars')
                        ->where('id', $car_id)
                        ->update($data);
                if($carpostupdate){
                    $result=array("code" => 200 , "success" => "true" , "message" => "Reported As Sold successfully." );
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }
        }
        
		$response = Response::json($result);
        return $response;
    }
    
    /**
     * Function name : send_notification
     * Task : Post send_notification
     * Auther : Sulekha Kumari
     */
    
    public function send_notification($notification_title, $notification_body , $tokenList , $notification_type , $relation_id , $otherdetails = array()){
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $FIREBASE_API_KEY = env('FIREBASE_API_KEY');

        $notification = [
            'title' =>$notification_title,
            'body' => $notification_body,
            'icon' =>'myIcon', 
            'sound' => 'mySound'
        ];
        $otherdetails = [
            'notification_type' =>$notification_type,
            'relation_id' => $relation_id
        ];
        $extraNotificationData = ["message" => $notification,"otherdetails" =>$otherdetails];

        $fcmNotification = [
            'registration_ids' => $tokenList, //multple token array
            // 'to'        => $token, //single token
            'notification' => $notification,
//            'data' => $otherdetails
             'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=' . $FIREBASE_API_KEY,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
//        return $result;
        
        // echo $result;
        // echo '<br>';
        // print_r($otherdetails);
    }
    
    /**
     * Function name : fcmtest
     * Task : Post fcmtest
     * Auther : Sulekha Kumari
     */
    
    public function fcmtest(Request $request){
        echo "fcmtest";
        
        $notification_title = "chat testing";
        $notification_body = "Notification Testing Body";
        $notification_tokens_list = array('dDMsKi_XRvSMJ3YFm4KygK:APA91bEcMHz2oIreRLOt0MsmOE5y3vSiKWsUaQ9XRKMq6v_p0rzHwRrxF8DelhvmJMe86M7bgy6H7BCnw-14jh8ui0sPJMiJEacIRLDSMfkI1uoFRV6elQ9Xj60hlQ8Pcg8fgq0NYsvx');
        $otherdetails = array();
        
        $to_user = 69;
        $notification_type = 'chat';
        $relation_id = 106;
        
        $notification_data = [
                'message' => $notification_title,
                'message_body'  => $notification_body,
                'to_user'       => trim($to_user),
                'notification_type'       => $notification_type,
                'relation_id'       => $relation_id,
                'status'       => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ];
        $addnotification =DB::table('notifications')->insert($notification_data);
        
        return $this->send_notification($notification_title, $notification_body , $notification_tokens_list , $notification_type , $relation_id , $otherdetails = $otherdetails);
        
//        $device_id = "cD1Bq2oIRoOqVCZA6S9x4H:APA91bHpD9Z-huRzPKBPHb5u34GOol4j3nOxQx54V2ctg8P5gky7KmPQfBobDJU2wWaETTtAd7oYysoD72F2IgoHBzvj9v2VxY2UiBnEf5L8p07kNGa3bDaVEhUGWAGNjqMb73X_F4dY";
//        $message = "carsbn notification testing new new";
//            
//        
//        //API URL of FCM
//        $url = 'https://fcm.googleapis.com/fcm/send';
//
//        /*api_key available in:
//        Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/    
//        $api_key = 'AAAAbAhS__M:APA91bH8O7ZuQwWHyTFS27RF3kh-iPyBWYa88HrBkONhXBzI5jkpa6NGgRwN8b7p0w8H542VTgy5G5DEYmQlPDmVaWgOc2NdbTPWLIL3LtP6HPmkgk9gAdUJfZ7cXV1Ndo8GZ6T45eWv';
//
//        $fields = array (
//            'registration_ids' => array (
//                    $device_id
//            ),
//            'data' => array (
//                    "message" => $message
//            )
//        );
//
//        //header includes Content type and api key
//        $headers = array(
//            'Content-Type:application/json',
//            'Authorization:key='.$api_key
//        );
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//        $result = curl_exec($ch);
//        if ($result === FALSE) {
//            die('FCM Send Error: ' . curl_error($ch));
//        }
//        curl_close($ch);
//        return $result;
    }
    
    public function logout(Request $request)
    {
        $access_token = $request->header('Authorization');
        $user_id = $request->header('USERID');        
        $authenticate_user = $this->authenticate_user($access_token, $user_id);
        if($authenticate_user === true){}else{
            $response = Response::json($authenticate_user, 401);
            return $response;
        }
        
        $update =DB::table('users')->where('id', $user_id)->update(['device_id'=>'']);

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






    
    //blog category API


    public function bloglist(){
        $getBlog =DB::table('blog')->where('status','Active')->orderBy('id', 'DESC')->get();
        $baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/';
        $videoUrl  =$baseUrl . '/';
		$finalBanners = array();
		foreach ($getBlog as $p) {
            $p->thumbnail = $imageUrl.$p->thumbnail;
			$p->blogvideo = $videoUrl.$p->blogvideo;
            $p->blogimage = $imageUrl.$p->blogimage;
			array_push($finalBanners, $p->blogimage);
		}


        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getBlog);
        
		$response = Response::json($result);
        return $response;
    }
    
    public function blogcategories(){
        $getBlog =DB::table('catblog')->where('status','Active')->orderBy('id', 'DESC')->get();
		

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getBlog);
        
		$response = Response::json($result);
        return $response;
    }





    public function blog_by_category($id){
        $getCountries =DB::table('blog')->where('blogcategory',$id)->orderBy('id', 'DESC')->get();
		
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        
		$response = Response::json($result);
        return $response;
    }





    public function blogsearch(Request $request ){     
        $search=$request->search;
		if($search){
        $getCountries =DB::table('blog')->where('title','LIKE','%'.$search.'%')->where('status','Active')->get();
		
			$result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        }else{
			$result=array("code" => 201 , "success" => "true" , "message" => "Record not Found" , 'data'=>(object)[]);
		}
		$response = Response::json($result);
        return $response;
    }





    public function blogdetail($id){
        $getCountries =DB::table('blog')->where('id',$id)->first();
	   $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);

        $response = Response::json($result);
        return $response;
    }
	
	
	// public function course_detail($id){
    //     $getCountries =DB::table('courses')->where('id',$id)->first();
	// 	$baseUrl    = URL::to('/');
	// 	$imageUrl   = $baseUrl . '/public/system/courses/';
	// 	$getCountries->thumbnail = $imageUrl.$getCountries->thumbnail;
	// 	$getCountries->main_image = $imageUrl.$getCountries->main_image;
	// 	$getCountries->gallery_images = $imageUrl.$getCountries->gallery_images;
    //     $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        
	// 	$response = Response::json($result);
    //     return $response;
    // }
	

    public function courselist(){
        $getcareer =DB::table('courses')->where('status','Online')->orderBy('id', 'DESC')->get();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/courses/';
		$videoUrl   = $baseUrl . '/public/system/courses/';

        $finalBanners = array();
		foreach ($getcareer as $p) {
			$p->gallery_images = $imageUrl.$p->gallery_images;

			$p->thumbnail = $imageUrl.$p->thumbnail;
            $p->main_image = $imageUrl.$p->main_image;
            $p->shorts = $videoUrl.$p->shorts;
            $p->fullvideo = $videoUrl.$p->fullvideo;

			array_push($finalBanners, $p->thumbnail);
		}

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getcareer);
        
		$response = Response::json($result);
        return $response;
    }

    public function careerlist(){
        $getcareer =DB::table('career')->where('status','Active')->orderBy('id', 'DESC')->get();
		

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getcareer);
        
		$response = Response::json($result);
        return $response;
    }

 
    public function careersearch(Request $request ){     
        $search=$request->search;
		if($search){
        $getCountries =DB::table('career')->where('title','LIKE','%'.$search.'%')->where('status','Active')->get();
		
			$result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        }else{
			$result=array("code" => 201 , "success" => "true" , "message" => "Record not Found" , 'data'=>(object)[]);
		}
		$response = Response::json($result);
        return $response;
    }

    public function FaqList(){
        $getfaq =DB::table('faq')->where('status','Active')->orderBy('id', 'DESC')->get();
		

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getfaq);
        
		$response = Response::json($result);
        return $response;   
    }
    public function testomoniallist(){
        $getfaq =DB::table('testomonial')->where('status','Active')->orderBy('id', 'DESC')->get();
        $baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/testomonial/';
        $videoUrl  =$baseUrl . '/public/system/testomonial/';
		$finalBanners = array();
		foreach ($getfaq as $p) {
            $p->image = $imageUrl.$p->image;
            $p->video = $videoUrl.$p->video;
			array_push($finalBanners, $p->image,$p->video );
		}

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getfaq);
        
		$response = Response::json($result);
        return $response;   
    }
     public function partnerlist(){
        $partner_section =DB::table('partner_section')->orderBy('id', 'ASC')->get();
        

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$partner_section);
        
		$response = Response::json($result);
        return $response;   
    }
     public function placementlist(){
     	$partner_section =DB::table('placement_update')->orderBy('id', 'ASC')->get();
        
        

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$partner_section);
        
		$response = Response::json($result);
        return $response;   
    }
     public function course_catalogelist(){
        $course_cataloge =DB::table('course_cataloge')->orderBy('id', 'ASC')->get()->toArray();
        foreach($course_cataloge as $key=>$item){

$item->image = asset('public/'.$item->image);
        }

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$course_cataloge);
        
		$response = Response::json($result);
        return $response;   
    }
     public function featuresList(){
        $partner_section =DB::table('features')->orderBy('id', 'ASC')->get();
        

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$partner_section);
        
		$response = Response::json($result);
        return $response;   
    }
    public function ourprogress(){
        $partner_section =DB::table('progress')->first();
      
$partner_section->faq = unserialize($partner_section->faq);
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$partner_section);
        
		$response = Response::json($result);
        return $response;   
    }
 public function ProgrammeOffer(){
        $partner_section =DB::table('ProgrammeOffer')->orderBy('id', 'ASC')->get();
        

       $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$partner_section);
        
		$response = Response::json($result);
        return $response;   
    }
	public function vlsiresourcelist(){
        $getfaq =DB::table('vlsi')->orderBy('id', 'DESC')->get();
        $baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/testomonial/';
        $videoUrl  =$baseUrl . '/public/system/testomonial/';
		$finalBanners = array();
		foreach ($getfaq as $p) {
            $p->pdf = $imageUrl.$p->pdf;
            $p->video = $videoUrl.$p->video;
			array_push($finalBanners, $p->pdf,$p->video );
		}

        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getfaq);
        
		$response = Response::json($result);
        return $response;   
    }
	public function searchvlsiresource(Request $request){     
        $search=$request->search;
		if($search){
        $getCountries =DB::table('vlsi')->where('title','LIKE','%'.$search.'%')->get();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/testomonial/';
		$finalBanners = array();
		foreach ($getCountries as $p) {
			$p->pdf = $imageUrl.$p->pdf;
            $p->video = $imageUrl.$p->video;
			array_push($finalBanners, $p->pdf,$p->video );
		}

			$result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getCountries);
        }else{
			$result=array("code" => 201 , "success" => "true" , "message" => "Record not Found" , 'data'=>(object)[]);
		}
		$response = Response::json($result);
        return $response;
    }
	
	public function vlsiresourcecatlilst(){
        $getfaq =DB::table('vlsi')->select('category')->orderBy('id', 'DESC')->get();
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getfaq);
        
		$response = Response::json($result);
        return $response;   
    }
	public function vlsiresourcecatfilter($cat){
        $getfaq =DB::table('vlsi')->where('category',$cat)->orderBy('id', 'DESC')->get();
		$baseUrl    = URL::to('/');
		$imageUrl   = $baseUrl . '/public/system/testomonial/';
        $videoUrl  =$baseUrl . '/public/system/testomonial/';
		$finalBanners = array();
		foreach ($getfaq as $p) {
            $p->pdf = $imageUrl.$p->pdf;
            $p->video = $videoUrl.$p->video;
			array_push($finalBanners, $p->pdf,$p->video );
		}
        $result=array("code" => 200 , "success" => "true" , "message" => "Record Found" , 'data'=>$getfaq);
        
		$response = Response::json($result);
        return $response;   
    }
    
    //Enquiry Api//
    public function addenquiry(Request $request){
        $name=$request->name;
		$email=$request->email;
		$phonenumber=$request->phonenumber;
		$country=$request->country;
        $state=$request->state;
        $message=$request->message;
		
		$mx_channel=$request->mx_channel;
		$source=$request->source;
        $mx_remarks=$request->mx_remarks;
        $mx_sub_source=$request->mx_sub_source;
		$page=$request->page;
		$captcha=$request->captcha;
	
        

		if(!isset($name)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Name is required.");
		}else if(!isset($phonenumber)){
			$result=array("code" => 201 , "success" => "false" , "message" => "phone number is required.");
		}else if(!isset($email)){
			$result=array("code" => 201 , "success" => "false" , "message" => "Valid Email is required.");
		}else{
			$date = date("Y-m-d H:i:s", time());
            $user = DB::table('enquiry')->where('email',$email)->whereOr('phonenum',$phonenumber)->select('email','phonenum')->first();
            if($user && $user->email==$email)
            {
				$result=array("code" => 201 , "success" => "false" , "message" => "Email already exists, please try another.");
            }else if($user && $user->phonenum==$phonenumber)
            {
                $result=array("code" => 201 , "success" => "false" , "message" => "Phone number already exists, please try another.");
            }else
            {
                
                $data = [
                    
                    'name'  => trim($name),
                    'email'      => trim($email),
                    'phonenum'   => trim($phonenumber),
                    'country'   => trim($country),
                    'state'    => trim($state),
                    'message' => trim($message),
					'mx_channel'   => trim($mx_channel),
                    'source'   => trim($source),
                    'mx_remarks'    => trim($mx_remarks),
                    'mx_sub_source' => trim($mx_sub_source),
					'page' => trim($page),
                    'captcha'  => $captcha,

                    
                ];
                $adduser =DB::table('enquiry')->insert($data);
                if($adduser){
					$postDate = array(array("Attribute"=>'firstname',"Value"=>$name),array("Attribute"=>'lastname',"Value"=>$name),array("Attribute"=>'emailaddress',"Value"=>$email),array("Attribute"=>'Phone',"Value"=>$phonenumber),array("Attribute"=>'mx_State',"Value"=>$state),array("Attribute"=>'mx_Country',"Value"=>$country),array("Attribute"=>'ProspectID',"Value"=>"xxxxxxxx-d168-xxxx-9f8b-xxxx97xxxxxx"),array("Attribute"=>'SearchBy',"Value"=>"Phone"),array("Attribute"=>'mx_Channel',"Value"=>$mx_channel),array("Attribute"=>'Source',"Value"=>$source),array("Attribute"=>'mx_Remarks',"Value"=>$mx_remarks),array("Attribute"=>'mx_Sub_Source',"Value"=>$mx_sub_source));
					$jsonLoad = json_encode($postDate);
					$acesskey = 'u$r3a919d3948c9705d4008c718deb19508';
					$secretkey = "0b2a2fa027b933c4b3f9f90de8b8efc2ab70235e";
					
					$curlOrder = curl_init();
					curl_setopt_array($curlOrder, array(
						CURLOPT_URL => "https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Capture?accessKey=$acesskey&secretKey=$secretkey",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_SSL_VERIFYHOST =>false,
						CURLOPT_SSL_VERIFYPEER => false,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 60,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $jsonLoad,
						CURLOPT_HTTPHEADER => array(
							"Content-Type: application/json"
						),
					));
					$orderKey = curl_exec($curlOrder);
					//print_r($orderKey);exit;
					$err = curl_error($curlOrder);
					curl_close($curlOrder);
                    $result=array("code" => 200 , "success" => "true" , "message" => "User added successfully.");
                }else{
                    $result=array("code" => 201 , "success" => "false" , "message" => "Something went wrong. Please try again.");
                }
            }	
		}        
        $response = Response::json($result);
        return $response;
    }
	
        
// vlsilist

}