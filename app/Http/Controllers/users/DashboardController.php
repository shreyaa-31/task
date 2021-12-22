<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class DashboardController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
        // dd(123);
       $data=Category::where('status','1')->get(['category_name', 'id']);
      
        return view('user.index',compact('data'));
    }
}
