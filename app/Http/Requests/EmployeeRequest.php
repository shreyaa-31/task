<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EmployeeRequest extends FormRequest
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
       
        if($request->hidden_id == ""){
            return [
                'emp_name' => 'required',
                'mobile' => 'required|min:10|max:10|unique:employees',
                'email' => 'required|email|unique:employees',
                'gender' => 'required',
                'dob' => 'required|date|before:18 years ago',
                'emp_joining_date' => 'required|date|after:dob',
               
            ];
        }
        else{
            return[
                'emp_name' => 'required',
                'mobile' => 'required|min:10|max:10|unique:employees,mobile,' . $request->hidden_id,
                'gender' => 'required',
                'email' => 'required|email|unique:employees,email,' . $request->hidden_id,
                'dob'=>'required|date|before:18 years ago',
                'emp_joining_date' => 'required|date|after:dob',
            ];
        }
      
        
    }

    public function messages()
    {
        return [
            'dob.before' => 'You must be at least 18 years old!',
            'emp_joining_date.after'=>'The date should be after date of birth',
        ];
    }
}


