<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Password;

class ForgotPasswordAction
{
    public function execute(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }
}
