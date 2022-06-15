<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            "user_id" => "required|integer",
            "role_id" => "required|integer"
        ];
    }

    public function messages()
    {
        return[
            "required" => "The :attribute cannot be blank."
        ];
    }
}
