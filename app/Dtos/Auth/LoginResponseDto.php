<?php

namespace App\Dtos\Auth;

use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class LoginResponseDto extends Data
{
    public function __construct(
        public string $token,
    ) {
    }
}
