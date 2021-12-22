<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubCategoryRequest extends FormRequest
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
        if ($request->id == "") {
            return [
                // 'category_name' => 'required',
                'subcategory_name' =>  [
                    'required',
                    Rule::unique('sub_categories')
                        ->where('category_id', $this->category)
                ]

            ];
        } else {
            return [
                'subcategory_name' =>  [
                    'required',
                    Rule::unique('sub_categories')
                        ->where('category_id', $request->category_name)->whereNot('id', $request->id)
                ]
            ];
        }
    }
}
