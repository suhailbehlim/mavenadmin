<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use App\Models\Admin;
use App\Models\User;
use App\Models\Category;


class DashboardController extends Controller
{

  /**
   * Function name : index
   * Parameter : null
   * task : show dashboard view and other required info.
   * auther : Manish Silawat
   */  	
    public function index() {

		if( session('adminId') == '' ) {

			return Redirect::to('admin/login');		
		}

		$data['active_link'] = 'dashboard'; 

		// get count of all Customer..
		$data['totalCustomers'] = User::where(['user_type' => 'student'])->count(); 

		// get count of all Dealer..
		$data['totalDealers'] = User::where(['user_type' => 'educator'])->count(); 
		$data['totalCat'] = Category::count(); 
		$data['totalCour'] = DB::table('courses')->count(); 
		$data['totalblog'] = DB::table('blog')->count(); 
		$data['totalCareer'] = DB::table('career')->count(); 
		$data['totaltest'] = DB::table('testomonial')->count(); 


        return view('admin.dashboard', $data);
    }

  /**
   * Function name : changePassword
   * Parameter : null
   * task : show change password view .
   * auther : Manish Silawat
   */  	
	public function changePassword() {

		$data['active_link'] = 'change_password';                 
		return view('admin.changePassword', $data);
	}

  /**
   * Function name : updatePassword
   * Parameter : request
   * task : Update password 
   * auther : Manish Silawat
   */ 
	public function updatePassword(Request $request) {
		
		$request->validate([
			'oldPassword' 	=> 'required|string',
			'password'	=> 'required|string|min:8|confirmed',
		]);

		// get admin information here..
		$adminInfo = DB::table('admins')->where('id', session('adminId'))->first();
        
		$storedHashPasswordInDb = $adminInfo->password;
		$oldPassword = $request->oldPassword;

	    if (Hash::check($oldPassword, $storedHashPasswordInDb)) {

	    	// update new password here..
	    	DB::table('admins')->where('id', session('adminId'))->update([
	    		'password' 	=> Hash::make(trim($request->password))
	    	]);

	    	return redirect()->route('admin.')->with('success', 'Password change successfully.');

	    } else {

	    	return back()->with('error', 'Old password field does not match.');
	    }

	}

  /**
   * Function name : updateProfile
   * Parameter : null
   * task : Load update profile view.. 
   * auther : Manish Silawat
   */ 
    public function updateProfile() {
	
		// get admin information.
		$data['adminInfo'] = Admin::where('id', session('adminId'))->first();

		$data['active_link'] = 'update_profile';         
		return view('admin.profile', $data);
	}

  /**
   * Function name : saveProfile
   * Parameter : null
   * task : Update profile information.
   * auther : Manish Silawat
   */ 	
	public function saveProfile(Request $request) {

		$request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|'.\Illuminate\Validation\Rule::unique('admins')->ignore(session('adminId')),
		]);

		Admin::where(['id' => session('adminId')])->update([
			'name' => ucfirst( $request->post('name') ),			
			'email' => trim($request->post('email')),
		]);

		// get admin updated info
		$adminInfo = DB::table('admins')->where('id', session('adminId'))->first();

		// update session data here..
        session([
            'adminId' => $adminInfo->id,
            'adminName' => $adminInfo->name,
            'adminEmail' => $adminInfo->email,
        ]);            

		return redirect()->route('admin.')->with('success', 'Admin profile updated successfully.');

	}    

  /**
   * Function name : logout
   * Parameter : null
   * task : Logout user from admin panel.
   * auther : Manish Silawat
   */ 
    public function logout() {		
	    //Auth::logout();
	  
	    Session::flush();
	    return Redirect()->route('login.admin');
	}

}
