<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthService
{
    public function login(string $email, string $password): bool
    {
        $result = Auth::attempt(['email' => $email, 'password' => $password]);
        if($result) Request::session()->regenerate();
        return $result;
    }

    public function logout(): void
    {
        Auth::logout();
        Request::session()->invalidate();
        Request::session()->regenerateToken();
    }

}
