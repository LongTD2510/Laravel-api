<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $response;
    public function __construct()
    {
        $this->response = response();
    }
    public function responseSuccess($data = [], $message = 'Successfully')
    {
        $res = [
            'code'          => 200,
            'success'       => true,
            'message'       => $message,
            'data'          => $data,
            'response_time' => date('Y-m-d H:i:s'),
        ];
        return $this->response->json($res);
    }
    public function responseError($message, $code = 400)
    {
        if ($code < 200 || $code > 600) {
            $code = 500;
        }
        $res = [
            'code'    => $code,
            'success' => false,
            'message' => $message,
        ];
        return $this->response->json($res, $code);
    }
    public function handleException(Exception $e)
    {
        $message = $e->getMessage();
        $code    = $e->getCode();
        return $this->responseError($message, $code);
    }
}
