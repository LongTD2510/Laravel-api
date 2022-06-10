<?php
namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserService
{
    public function validateData($params)
    {
        $rule = [
            'email'    => 'required|email|unique:users',
            'password' => ['required', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()],
            'name'     => 'required|unique:users',
        ];
        $message = [
            'required'    => 'The :attribute cannot be blank.',
            'email'       => 'Please enter a valid email address.',
            'unique'      => 'This :attribute has been taken.',
            'name.unique' => 'This name has been taken.',
        ];
        return Validator::make($params, $rule, $message);
    }

    public function validateLogin($params)
    {
        $rule = [
            'email' => ['required','email','exists:users,email'],
            'password' => ['required'],
        ];
        $message = [
            'required'=> 'The :attribute cannot be blank.',
            'email' => 'Please enter a valid email address.',
            'exists' => 'This :attribute has not been registered yet.',
        ];
        return Validator::make($params, $rule, $message);
    }

    public function createUser($params)
    {
        return DB::transaction(function() use($params){
            $user = new User();
            $user->email = $params['email'];
            $user->password = bcrypt($params['password']);
            $user->name = $params['name'];
            $user->save();
            return $user;
        },5);
    }

}
