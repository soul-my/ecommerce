<?php

namespace App\Http\Requests\Validations\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryValidation extends FormRequest
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
            'name' => 'required|min:5|max:255',
            'status' => 'required',
            'featured' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'status.required'  => 'A status is required',
            'featured.required' => 'A featured is required',
        ];
    }
}
