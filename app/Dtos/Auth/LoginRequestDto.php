<?php

namespace App\Dtos\Auth;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class LoginRequestDto extends Data
{
    public function __construct(
        #[Email]
        public string $email,
        #[StringType]
        public string $password,
    ) {
    }
}
