<?php

namespace App\Dtos\Auth;

use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class ChangePasswordRequestDto extends Data
{
    public function __construct(
        #[StringType]
        public string $current_password,
        #[StringType]
        public string $password,
    ) {
    }
}
