<?php

namespace App\Exceptions;

use App\Dtos\Extra\ExceptionResponseDto;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class HttpException extends Exception
{
    public function __construct(
        public string  $code_str,
        public int     $http_code,
        public ?object $data = null,
        public array   $headers = [],
    ) {
        parent::__construct(__($code_str));
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function render(Request $request): JsonResponse|bool
    {
        if($request->isJson()) {
            return Response::json(
                ExceptionResponseDto::fromHttpException($this),
                $this->http_code,
                $this->headers
            );
        }
        return false;
    }

    static function invalidCredentials(): HttpException
    {
        return new HttpException('auth.invalid_credentials', 400);
    }

    static function incorrectCurrentPassword(): HttpException
    {
        return new HttpException('auth.incorrect_current_password', 400);
    }

}
