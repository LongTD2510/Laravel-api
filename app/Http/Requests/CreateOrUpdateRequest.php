<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'product_id'   => 'required|integer',
            'product_name' => 'required|string|max:255',
            'image'        => 'mimes:png,jpg,jpeg|max:2048',
            'price'        => 'required|numeric|min:0',
            'description'  => 'required|string|max:200',
        ];
    }
    public function messages()
    {
        return [
            'required'        => 'The :attribute cannot be blank.',
            'image.mimes'     => 'The :attribute incorrect format png,jpg,jpeg',
            'description.max' => 'The description cannot exceed 200 characters.',
        ];
    }
}
