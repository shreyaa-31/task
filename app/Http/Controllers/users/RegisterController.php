<?php

namespace App\Http\Controllers\users;

use Mail;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\DataTables\users\UserDataTable;
use App\Http\Requests\RegisterRequest;
use App\Mail\ForgetPassword;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{


    public function showLoginForm(Request $request)
    {

        if (Auth::check()) {
            $data=Category::where('status','1')->get(['category_name', 'id']);
            return view('user.index',compact('data'));
        }

        $data = Category::where('status', 1)->get(['category_name', 'id']);
        return view('user.register', ['data' => $data]);
    }


    public function getcat(Request $request)
    {
        // dd($request->all());
        $data = Subcategory::where('category_id', $request->catId)
            ->where('status', 1)
            ->get(['subcategory_name', 'id']);
            // dd($data);
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function store(RegisterRequest $request)
    {
     
       
        $validatedData = new User;
        $validatedData->firstname = $request->input('firstname');
        $validatedData->lastname = $request->input('lastname');
        $validatedData->email = $request->input('email');
        $validatedData->category_id = $request->input('category');
        $validatedData->subcategory_id = $request->input('subcategory');
        $imageName = time() . '.' . $request->profile->extension();
        $request->profile->move(public_path('images'), $imageName);
        $validatedData->profile = $imageName;
        $validatedData->password = Hash::make($request->input('password'));
        $validatedData->otp = rand(1111, 9999);

        $validatedData->save();

       
        Mail::to($validatedData->email)->send(new Welcome($validatedData));

        return response()->json(['status' => true, 'data' => $validatedData, 'message' => "Mail sent"]);
    }


    public function enterotp(User $id)
    {
        // dd($id);
       
        $id->otp = rand(1111, 9999);
        $id->save();

        Mail::to($id->email)->send(new Welcome($id));
        return view('user.enter-otp', compact('id'));
    }


    public function verify_otp(Request $request)
    {
        $userid = $request->id;
        $data = User::find($request->id);
        // dd($request->all());
        if ($request->enterotp == $data['otp']) {
            $data->is_verify = '1';
            $data->otp = '';
            $data->update();
            return response()->json(['status' => true, 'data' => $data, 'message' => "Account Verify"]);
        } else {
            return response()->json(['status' => false, 'data' => $data, 'message' => "Enter Correct OTP"]);
        }
    }


    public function forget_pass()
    {
        return view('user.forget-pass');
    }

    public function getemail(Request $request)
    {
        $data = User::where('email', $request->enteremail)->first();
        // dd($data['email']);
        if (!empty($data)) {
            if ($request->enteremail == $data['email']) {
                $data['otp']=rand(1111,9999);
                $data->save();
                
                Mail::to($request->enteremail)->send(new ForgetPassword($data));
                return view('user.password_otp_verify',compact('data'));
            }
        } else {
            return Redirect::back()->withErrors(['msg' => 'Please enter Your registered email']);
        }
    }

    public function verify_otp_password(Request $request)
    {
        // dd($request->all());
        $userid = $request->id;
        $data = User::find($request->id);
        // dd($request->all());
        if ($request->enterotp == $data['otp']) {
            $data->otp = '';
            $data->update();
            return view('user.password',compact('data'));
        } else {
            return Redirect::back()->withErrors(['msg' => 'Enter correct OTP']);
        }
    }

    public function password_change(PasswordRequest $request)
    {
        // dd(123);
       
        $data = User::find($request->hidden_id);
        // dd($data);
        if ($request->password == $request->cpassword) {
            $data->password = Hash::make($request->input('password'));
            $data->update();
            return response()->json(['status' => true, 'message' => "Password Change Successfully"]);
        } 
    }

    
}
