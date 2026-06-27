<?php

namespace App\Services\Auth;

use App\Actions\Auth\ForgotPasswordAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\ResetPasswordAction;
use Illuminate\Support\Facades\Password;


class AuthService
{
    public function __construct(
        private LoginAction $loginAction,
        private RegisterAction $registerAction,
        private ForgotPasswordAction $forgotPasswordAction,
        private ResetPasswordAction  $resetPasswordAction,

    ) {}

    public function login(array $data): array|false
    {
        return $this->loginAction->execute($data);
    }

    public function register(array $data): array
    {
        return $this->registerAction->execute($data);
    }

    public function forgotPassword(string $email): bool
    {
        $status = $this->forgotPasswordAction->execute($email);
        return $status === Password::RESET_LINK_SENT;
    }

    public function resetPassword(array $data): bool
    {
        $status = $this->resetPasswordAction->execute($data);
        return $status === Password::PASSWORD_RESET;
    }

    public function logout($user)
    {

        $user->currentAccessToken()->delete();
    }
}
