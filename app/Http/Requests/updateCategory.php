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
            'category_name' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Category id cannot be blank.',
            'category_name' => 'Category name cannot be blank.'
        ];
    }
}
