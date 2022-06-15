<?php
namespace App\Http\Services;

use App\Models\RoleUser;
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
            'email'    => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ];
        $message = [
            'required' => 'The :attribute cannot be blank.',
            'email'    => 'Please enter a valid email address.',
            'exists'   => 'This :attribute has not been registered yet.',
        ];
        return Validator::make($params, $rule, $message);
    }

    public function createUser($params)
    {
        return DB::transaction(function () use ($params) {
            $user           = new User();
            $user->email    = $params['email'];
            $user->password = bcrypt($params['password']);
            $user->name     = $params['name'];
            $user->save();
            return $user;
        }, 5);
    }

    public function makeRoleUser($param)
    {
        return DB::transaction(function () use ($param) {
            $roleUser = $this->findAndCreate($param);
            return $roleUser;
        }, 5);
    }

    public function findAndCreate($param)
    {
        return DB::transaction(function () use ($param) {
            $data = [
                'user_id' => $param['user_id'],
                'role_id' => $param['role_id'],
            ];
            $user = RoleUser::where('user_id', $param['user_id'])->where('role_id', $param['role_id'])->firstOrCreate($data);
            return $user;
        }, 5);
    }

    public function getUserById($id)
    {
        return User::with(['roles'])->where('id', $id)->firstOrFail();
    }
}
