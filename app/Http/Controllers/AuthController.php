<?php

namespace App\Http\Controllers;

use App\Dtos\Auth\ChangePasswordRequestDto;
use App\Dtos\Auth\LoginRequestDto;
use App\Dtos\Auth\LoginResponseDto;
use App\Dtos\Extra\MessageResponseDto;
use App\Dtos\Models\UserDto;
use App\Exceptions\HttpException;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    /**
     * @throws HttpException
     * @throws \Exception
     */
    public function login(LoginRequestDto $dto): LoginResponseDto
    {
        $result = $this->authService->authenticate($dto->email, $dto->password);
        if(!$result) throw HttpException::invalidCredentials();
        $token = $this->authService->createToken();
        return new LoginResponseDto(token: $token->plainTextToken);
    }

    public function logout(): MessageResponseDto
    {
        $this->authService->deleteCurrentToken();
        return new MessageResponseDto(__('auth.logged_out'));
    }

    /**
     * @throws \Throwable
     */
    public function changePassword(ChangePasswordRequestDto $dto): MessageResponseDto
    {
        if (!$this->authService->checkCurrentPassword($dto->current_password))
            throw HttpException::incorrectCurrentPassword();
        $this->authService->changePassword($dto->password);
        return new MessageResponseDto(__('auth.password_changed'));
    }

    public function whoAmI(): UserDto
    {
        return UserDto::fromModel($this->authService->getCurrentUser());
    }
}
