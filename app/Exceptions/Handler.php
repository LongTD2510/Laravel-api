<?php

namespace App\Exceptions;

use App\Http\Responses\ErrorResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->renderable(function (Throwable $e) {
            // if ($request->is('api/*')) {
            //     return response()->json(
            //         [
            //             'message' => 'Object not found',
            //             'code'    => 404,
            //         ], 404);
            // }
        });
    }
    
    public function render($request, Throwable $e)
    {
        if ($e instanceof HttpResponseException && $e->getResponse()->getStatusCode() === 401) {
            throw new AuthenticationException();
        }
        $errorResponse = new ErrorResponse($e);
        $response = $errorResponse->toResponse();

        return response()->json($response, $errorResponse->httpCode);
    }
}
