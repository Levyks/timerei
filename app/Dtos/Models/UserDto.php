<?php

namespace App\Dtos\Models;

use App\Models\User;
use Spatie\LaravelData\Data;

class UserDto extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ) {
    }

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
        );
    }
}
