<?php

namespace App\Http\Responses;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ErrorResponse
{

    public int $httpCode;

    public function __construct(Throwable $exception)
    {
        $this->httpCode  = 500;
        $this->exception = $exception;
    }

    public function toResponse(): array
    {
        switch (true) {
            case $this->exception instanceof NotFoundHttpException:
                $this->httpCode = 404;
                return [
                    'success' => false,
                    'code'    => $this->httpCode,
                    'message' => $this->exception->getMessage(),
                ];
            case $this->exception instanceof AuthenticationException:
                $this->httpCode = 401;
                return [
                    'success' => false,
                    'code'    => $this->httpCode,
                    'message' => $this->exception->getMessage(),
                ];
            case $this->exception instanceof AuthorizationException:
                $this->httpCode = 403;

                return [
                    'success' => false,
                    'code'    => $this->httpCode,
                    'message' => $this->exception->getMessage(),
                ];
            case $this->exception instanceof ModelNotFoundException:
                $this->httpCode = 404;

                return [
                    'success' => false,
                    'code'    => $this->httpCode,
                    'message' => $this->transformMessageModelNotFound($this->exception),
                ];
            case $this->exception instanceof ValidationException:
                $this->httpCode = 422;

                return [
                    'success' => false,
                    'code'    => $this->httpCode,
                    'message' => $this->exception->errors(),
                ];
            default:
                $this->httpCode = 500;
                if (env('APP_DEBUG') == true) {
                    return [
                        'success' => false,
                        'code'    => $this->httpCode,
                        'message' => $this->exception->getMessage(),
                        'error'   => [
                            'id'            => $this->exception->getCode(),
                            'message'       => $this->exception->getMessage(),
                            'file'          => $this->exception->getFile(),
                            'line'          => $this->exception->getLine(),
                            'trace'         => $this->exception->getTrace(),
                            'traceAsString' => $this->exception->getTraceAsString(),
                        ],
                    ];
                }
                return [
                    'success' => false,
                    'code'    => $this->httpCode,
                    'message' => __('messages.unknown_occurred'),
                ];
        }
    }

    public function transformMessageModelNotFound($exception): string
    {
        $modelNameExploded = explode("\\", $exception->getModel());
        $modelName         = $modelNameExploded[count($modelNameExploded) - 1];

        return __('messages.model_not_found', ['model' => $modelName]);
    }
}
