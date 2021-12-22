<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;

class DashboardController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    public function showDashboared()
    {
        $user = User::all()->count();
        $emp = Employee::all()->count();
       
        return view('admin.dashboard.index',compact('user','emp'));
    }

    
    
   
}
