<?php

namespace App\Dtos\Extra;

use App\Exceptions\HttpException;
use Spatie\LaravelData\Data;

class ExceptionResponseDto extends Data
{
    public function __construct(
        public string $code,
        public string $message,
        public ?array  $data
    )
    {
    }

    public static function fromHttpException(HttpException $exception): self
    {
        return new self(
            code: $exception->code_str,
            message: $exception->getMessage(),
            data: $exception->data,
        );
    }
}

