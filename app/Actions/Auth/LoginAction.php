<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function execute(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return false;
        }

        $expiration = ! empty($data['remember_me'])
            ? now()->addDays(30)
            : now()->addDay();

        $token = $user->createToken('auth_token', ['*'], $expiration)->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }
}
