<?php

namespace App\Http\Controllers;

use App\Dtos\Auth\LoginRequestDto;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequestDto $dto): JsonResponse
    {
        $result = $this->authService->login($dto->email, $dto->password);
        if(!$result) return $this->jsonResponse(__('auth.failed'), null, 400);
        return $this->jsonResponse(__('auth.logged_in'));
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return $this->jsonResponse(__('auth.logged_out'));
    }
}
