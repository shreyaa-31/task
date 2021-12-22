<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRequest extends FormRequest
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
                'category_name' => 'required|unique:categories,category_name,NULL,id,deleted_at,NULL',
            ];
        }
        else{
            return [
                'category_name' => 'required|unique:categories,category_name,'. $request->id,
            ];
        }

       
    }
}


