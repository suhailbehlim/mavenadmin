<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Redirect;

use App\Models\Admin;
use App\Mail\AdminForgetPasswordMail;
use Illuminate\Support\Facades\Mail;


class AdminForgetPasswordController extends Controller
{

  /**
   * Function name : index
   * Parameter : null
   * task : show admin forget password view .
   * auther : Manish Silawat
   */ 	
	public function index() {

		return view('admin.forgetPassword',['url' => 'admin', 'title' => 'Admin']);
	}

  /**
   * Function name : sendPasswordOnMail
   * Parameter : request
   * task : Send password on registered email .
   * auther : Manish Silawat
   */ 	
	public function sendPasswordOnMail(Request $request) {

		$request->validate([
			'email' => 'required|email|min:8'
		]);		

		// check email is in database or not.
		$adminInfo = Admin::where(['email' => trim($request->email)])->first();

		if(!empty($adminInfo)) {

			$randomPassword = $this->generateRandomPassword(8);
			$mailData['randomPassword'] = $randomPassword;

			// update password in database..
			Admin::where(['email' => trim($request->email)])->update([

				'password' => Hash::make(trim($randomPassword))

			]);

			// get admin updated information here..
			$adminUpdatedInfo = Admin::where(['id' => $adminInfo->id ])->first();
			//
			session([
				'mailAdminName' => $adminUpdatedInfo->name,
				'mailAdminEmail'=> $adminUpdatedInfo->name,
				'mailAdminPassword' => $randomPassword
			]);

			// send mail to admin user..
		    Mail::to($adminInfo->email)->send(new AdminForgetPasswordMail());         

			$message = "We have send new password on your registered email, please check it and updated it once login ";
			
			return back()->with('success', $message);

		} else {

			return back()->with('error', "We can't find a user with that e-mail address.");

		}

	}

  /**
   * Function name : generateRandomPassword
   * Parameter : length
   * task : Generate random password.
   * auther : Manish Silawat
   */ 	
	function generateRandomPassword( $length ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    return substr(str_shuffle($chars),0,$length);
	}
}