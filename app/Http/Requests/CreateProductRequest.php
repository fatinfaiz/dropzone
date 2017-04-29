<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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

            'product_name'=>'required',
            'product_description'=>'required',
            'product_price'=>'required',
            'condition'=>'required',
            'state_id'=>'required',
            'area_id'=>'required',
            'category_id'=>'required',
            'subcategory_id'=>'required',
            'brand_id'=>'required',
            'product_image'=>'image|mimes:png,jpg'

            //
        ];
    }
}
