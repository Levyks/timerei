<?php

namespace App\Services;

use App\Models\User;

class UsersService
{
    public function findByEmail(string $email): User | null
    {
        return User::where('email', $email)->first();
    }

}
