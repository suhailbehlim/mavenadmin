<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


use Illuminate\Http\Request;
use Auth;
use App\Models\User;

// import laravel package for social login and signup.
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        // $this->middleware('guest:admin')->except('logout');

    }

    public function showAdminLoginForm()
    {
        
        return view('auth.login', ['url' => 'admin', 'title' => 'Admin']);
    }


    public function adminLogin(Request $request)
    {
        // print_r($request); exit;
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {


            // set session data.. 
            session([
                'adminId' => Auth::guard('admin')->user()->id,
                'adminName' => Auth::guard('admin')->user()->name,
                'adminEmail' => Auth::guard('admin')->user()->email,
            ]); 

            return redirect()->route('admin.');
        } else {

            return back()->with("error", "Sorry, we don't recognize you by provided information.");
        }


        return back()->withInput($request->only('email', 'remember'));
    }
    

    // Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
        
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        //echo "<pre>"; print_r($user);die;
        // call function here.
        $this->_registerOrLoginUser($user);
        // redirect after login or signup.
        return redirect()->route('home');
    }   
    
    
    // Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    
    
    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        // call function here.
        $this->_registerOrLoginUser($user);
        // redirect after login or signup.
        return redirect()->route('home');

    }    


    protected function _registerOrLoginUser($data) {
        
        $user = User::where('email', '=', $data->email)->first();

        if(!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->social_id = $data->id;
            $user->avatar = $data->avatar;

            $user->save();
        }

        //add session data
        session([
            'userId' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'social_id' => $user->social_id
        ]);

        Auth::login($user);
    }


}
