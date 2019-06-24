<?php

namespace App\Http\Requests\Validations\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductValidation extends FormRequest
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
            "title" => 'required|string|min:5|',
            "category" => 'required',
            "description" => 'required|string|min:5|',
            "file_id_1" => 'nullable',
            "file_id_2" => 'nullable',
            "file_id_3" => 'nullable',
            "files" => 'required',
            "base" => 'required|numeric|',
            "sell" => 'required|numeric|',
            "sku" => 'nullable',
            "barcode" => 'nullable',
            "quantity" => 'required',
            "allowbuy" => 'nullable',
            "variant_key_id_1" => 'nullable',
            "variant_key_id_2" => 'nullable',
            "variant_key_id_3" => 'nullable',
            "pagetitle" => 'nullable',
            "metadescription" => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            "title.required" => 'name is required',
            "category.required" => 'category is required',
            "description.required"  => 'description is required',
            "image.required" => 'atleast one image is required',
            "base.required" => 'base price is required',
            "sell.required"  => 'sell price is required',
            "quantity.required" => 'quantity is required',
        ];
    }
}
