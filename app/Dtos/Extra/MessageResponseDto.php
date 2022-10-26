<?php

namespace App\Dtos\Extra;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\StringType;

class MessageResponseDto extends Data
{
    public function __construct(
        public string $message,
    )
    {
    }
}

