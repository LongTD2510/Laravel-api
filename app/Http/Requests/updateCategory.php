<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateCategory extends FormRequest
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
            //
            'category_id' => 'required|integer',
            'product_id' => 'required|integer'
        ];
    }
    public function messages()
    {
        return [
            'required' => 'The :attribute cannot be blank.',
        ];
    }
}
