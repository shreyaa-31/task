<?php

namespace App\Http\Middleware;

use Closure;
use Mail;
use Illuminate\Support\Facades\Redirect;
use App\Mail\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       
        if (Auth::guard('web')->user()) {
            $userid = Auth::user()->email;
            // dd($userid);
            if (Auth::user()->is_verify == 0) {

                return redirect()->route('enterotp',$userid)->withErrors(['msg' => 'Please verify your Account']);
            } else if (Auth::user()->status == 0) {
                return Redirect::back()->withErrors(['message' => 'Your Account is inactive by admin']);
            }
        }
        
        return $next($request);
    }
}
