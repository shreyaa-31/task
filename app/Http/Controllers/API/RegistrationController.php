<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;


class RegistrationController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        $validatedData = new User;
        $validatedData->firstname = $request->firstname;
        $validatedData->lastname = $request->lastname;
        $validatedData->email = $request->email;
        $validatedData->category_id = $request->category_id;
        $validatedData->subcategory_id = $request->subcategory_id;
        $imageName = time() . '.' . $request->profile->extension();
        $request->profile->move(public_path('images'), $imageName);
        $validatedData->profile = $imageName;
        $validatedData->password = Hash::make($request->input('password'));
        $validatedData->otp = rand(1111, 9999);
        $validatedData->remember_token = md5(uniqid(rand(), true));

        $validatedData->save();


        // $success['token'] =  $validatedData->createToken('MyApp')->accessToken;
        $success = [];
        $success['otp'] = $validatedData->otp;
        $success['remember_token'] = $validatedData->remember_token;

        return $this->sendResponse($success, 'Register Successfully');

    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' =>$request->email, 'password' => $request->password])) {

            $user = Auth::user();

            if ($user->is_verify == 0) {

                $user->otp = rand(1111, 9999);

                $user->remember_token = md5(uniqid(rand(), true));
                $user->save();


                return $this->sendError($user, ['error' => 'Verify Your Account']);
            } elseif ($user->status == 0) {
                return $this->sendError('Unauthorised.', ['error' => 'Admin block your account']);
            } else {
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                return $this->sendResponse($success, 'User login successfully.');
            }
        } else {
            return $this->sendResponse([], "Enter Valid crediantals");
        }
    }

    public function verify_otp(Request $request)
    {
        // dd($request->all());
        if (request()->hasHeader('VerifyToken')) {

            $verifyToken = request()->header('VerifyToken');
            $user = User::where('remember_token', $verifyToken)->first();
            // dd($user);
        }

        if ($request->enterotp == $user['otp']) {
            $user->is_verify = '1';
            $user->otp = '';
            $user->remember_token = '';
            $user->save();
            $success['email'] = $user->email;
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return $this->sendResponse($success, 'Account Verify');
        } else {
            return $this->sendResponse([], 'Enter Correct OTP');
        }
    }

    public function email_verify(Request $request)
    {
        $data = User::where('email', $request->email)->first();

        if (!empty($data)) {
            $data['otp'] = rand(1111, 9999);
            $data['remember_token'] = md5(uniqid(rand(), true));
            $data->save();

            $user['otp'] = $data->otp;
            $user['remember_token'] = $data->remember_token;

            return $this->sendResponse($user, 'Token generate');
        } else {
            return $this->sendResponse([],'Enter registered email');
        }
    }

    public function reset_password(Request $request)
    {
        if (request()->hasHeader('VerifyToken')) {

            $verifyToken = request()->header('VerifyToken');
            $user = User::where('remember_token', $verifyToken)->first();
            if ($request->otp == $user['otp']) {
                $user->password = Hash::make($request->password);
                $user->remember_token = '';
                $user->otp = '';
                $user->save();
                return $this->sendResponse($user, 'Password Change Successfully');
            } else {
                return $this->sendResponse([],'Enter Correct OTP');
            }
        }
    }

    public function details()
    {
        $user = User::get();
        return $this->sendResponse($user, 'Users');
    }
}
