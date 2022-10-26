<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Laravel\Sanctum\NewAccessToken;

class AuthService
{
    public function authenticate(string $email, string $password): bool
    {
        return Auth::attempt(['email' => $email, 'password' => $password]);
    }

    public function checkCurrentPassword(string $password): bool
    {
        return Hash::check($password, Auth::user()->password);
    }

    public function createToken(): NewAccessToken
    {
        return Auth::user()->createToken(Request::ip());
    }

    public function deleteCurrentToken(): void
    {
        Auth::user()->currentAccessToken()->delete();
    }

    public function deleteAllTokens(): void
    {
        Auth::user()->tokens()->delete();
    }

    public function changePassword(string $new_password): void
    {
        Auth::user()->password = Hash::make($new_password);
        Auth::user()->save();

        $this->deleteAllTokens();
    }

    public function getCurrentUser(): User
    {
        return Auth::user();
    }

}
