<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\AuthController;
use App\Http\Requests\RoleRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        parent::__construct();
    }

    public function register(Request $request)
    {
        $params    = $request->all();
        $validator = $this->userService->validateData($params);
        if ($validator->fails()) {
            return $this->responseError($validator->messages());
        }
        $user = $this->userService->createUser($params);
        $auth = new AuthController();
        Log::debug('User register========', ['user' => $user]);
        $token = $auth->createToken($params);
        return $auth->returnWithToken($user, $token);
    }

    public function login(Request $request)
    {
        $params    = $request->all();
        $validator = $this->userService->validateLogin($params);
        if ($validator->fails()) {
            return $this->responseError($validator->messages());
        }
        $credentials = [
            'email'    => $params['email'],
            'password' => $params['password'],
        ];
        if (!Auth::attempt($credentials)) {
            return $this->responseError(__('messages.incorrect_password'), 401);
        }
        $auth  = new AuthController();
        $token = $auth->createToken($params);
        return $auth->returnWithToken(Auth::user(), $token);
    }

    public function logout(Request $request)
    {
        $logout = $request->user()->token()->revoke();
        return $this->responseSuccess($logout);
    }

    public function searchProduct(Request $request)
    {
        $params = $request->all();
        $resuls = $this->userService;
        return $this->responseSuccess($resuls);
    }

    public function chooseRole(RoleRequest $roleRequest)
    {
        $params = $roleRequest->all();
        $user   = $this->userService->makeRoleUser($params);
        $result   = $this->userService->getUserById($params['user_id']);
        return $this->responseSuccess($result);
    }
}
