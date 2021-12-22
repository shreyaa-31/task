<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BlogCategoryRequest extends FormRequest
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
       
            if($request->id == ""){
                return [
                    'blog_name' => 'required|unique:blogcategories,name,NULL,id,deleted_at,NULL',
                ];
            }
            else{
                return [
                    'blog_name' => 'required|unique:blogcategories,name,'. $request->id,
                ];
            }
        
    }
}
