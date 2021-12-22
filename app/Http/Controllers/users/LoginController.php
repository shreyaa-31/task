<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "dashboard";

    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }

    public function showLoginForm()
    {

        return view('user.login');
    }

   
    public function attemptLogin(Request $request)
    {
  
       
        Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password]);        
        
        if (Auth::guard('web')->check()) {

            return redirect()->route('blogview');

        }else{
          
            return redirect()->route('user.login')->withErrors("Enter valid credentials");
        }
    }

    

    public function logout(Request $request)
    {

        $this->guard('web')->logout();
        return redirect()->route('user.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function register()
    {
        return view('user.register');
    }
}





