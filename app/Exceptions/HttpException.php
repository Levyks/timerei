<?php

namespace App\Exceptions;

use App\Dtos\Extra\ExceptionResponseDto;
use App\Enums\Permission;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class HttpException extends Exception
{
    public function __construct(
        public string            $code_str,
        public                   $message,
        public int               $http_code,
        public object|array|null $data = null,
        public array             $headers = [],
    ) {
        parent::__construct($message);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function render(Request $request): JsonResponse|bool
    {
        if($request->expectsJson()) {
            return Response::json(
                ExceptionResponseDto::fromHttpException($this),
                $this->http_code,
                $this->headers
            );
        }
        return false;
    }

    static function unauthenticated(): HttpException
    {
        return new HttpException('auth.unauthenticated', __('auth.unauthenticated'), 401);
    }

    static function invalidCredentials(): HttpException
    {
        return new HttpException('auth.invalid_credentials', __('auth.invalid_credentials'), 400);
    }

    static function incorrectCurrentPassword(): HttpException
    {
        return new HttpException('auth.incorrect_current_password', __('auth.incorrect_current_password'), 400);
    }

    static function fromValidationException(ValidationException $e): HttpException
    {
        return new HttpException(
            'validation.failed',
            __('validation.failed', [ 'message' => $e->getMessage() ]),
            422,
            [ 'fields' => $e->errors() ]
        );
    }

    static function fromAccessDeniedHttpException(AccessDeniedHttpException $e): HttpException
    {
        /**
         * Refer to comment about jankyness in `\App\Policies\BasePolicy::check` method
         */
        return new HttpException(
            'auth.access_denied',
            __('auth.access_denied', [ 'permissions' => $e->getMessage() ]),
            403,
            [ 'missing_permissions' => explode(', ', $e->getMessage()) ]
        );
    }

}
