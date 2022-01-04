<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        // dd($request->all());
        if($request->id == ""){
            return [
                'firstname' => 'required|regex:/^[a-zA-Z]+$/u',
                'lastname' => 'required|regex:/^[a-zA-Z]+$/u',
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'subcategory_id' => 'required',
                'category_id' => 'required',
                'password' => 'required',
                'profile' => 'required|mimes:jpeg,png,jpeg',
               
            ];
        }
        else{
            return[
                'firstname' => 'required|regex:/^[a-zA-Z]+$/u',
                'lastname' => 'required|regex:/^[a-zA-Z]+$/u',
                'email' => 'required|email|unique:users,email,'. $request->id,
                'profile' => 'mimes:jpeg,png,jpeg',

                
            ];
        }
      
        
        
    }

    public function messages()
    {
        return [
            
            
            'password.regex' => "Your Password must have one Uppercase,One LowerCase,One Special Character,more than six character and one numeric value",
            
        ];
    }
}
