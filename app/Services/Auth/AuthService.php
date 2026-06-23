<?php

namespace App\Services\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAction;

class AuthService
{
    public function __construct(
        private LoginAction $loginAction,
        private RegisterAction $registerAction,
    ) {}

    public function login(array $data): array|false
    {
        return $this->loginAction->execute($data);
    }

    public function register(array $data): array
    {
        return $this->registerAction->execute($data);
    }
}
