<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        parent::__construct();
    }

    public function createToken($params)
    {
        $client = DB::table('oauth_clients')->where('password_client', true)->first();
        $data   = [
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $params['email'],
            'password'      => $params['password'],
            'scope'         => '',
        ];
        $request = Request::create('/oauth/token', 'POST', $data);
        return json_decode(app()->handle($request)->getContent());
    }

    public function returnWithToken($user, $token)
    {
        $user['access_token'] = $token->access_token;
        $user['refresh_token'] = $token->refresh_token;
        $user['expires_at'] = $token->expires_in;
        Log::debug('User Login======'.$this->responseSuccess($user));
        return $this->responseSuccess($user);
    }
}
