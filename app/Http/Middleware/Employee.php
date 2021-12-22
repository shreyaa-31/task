<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Employee extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {
            return route('employee-login');
        } else {
            return route('emp-dashboard');
        }
    }
}
