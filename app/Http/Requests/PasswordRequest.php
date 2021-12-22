<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
    public function rules()
    {
        return [
            'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'cpassword' => 'required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            
            
            'password.regex' => "Your Password must have one Uppercase,One LowerCase,One Special Character,more than six character and one numeric value",
            
        ];
    }
}
