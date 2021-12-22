<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckEmployeeStatus
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
        
        if (Auth::guard('employee')->user()) {
          
            if (Auth::guard('employee')->user()->status == 0) {
                // dd('mnbgf');
                return Redirect::back()->withErrors(['message' => 'Your Account is inactive by admin']);
            }
        }
        return $next($request);
    }
}
