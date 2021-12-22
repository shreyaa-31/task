<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
    public function index(Request $request) {
        
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);  
       
        return redirect()->back();
     }
}
