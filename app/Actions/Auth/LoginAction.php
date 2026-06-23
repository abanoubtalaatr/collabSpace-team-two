<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function execute(array $data)
    {
        $credentials = [
            'email'    => $data['email'],
            'password' => $data['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();
        $expiration = isset($data['remember_me']) && $data['remember_me']
            ? now()->addDays(30)
            : now()->addDay();

        $token = $user->createToken('auth_token', ['*'], $expiration)->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }
}
