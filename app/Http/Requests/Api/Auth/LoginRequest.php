<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
            'remember_me' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'email field is required',
            'email.email' => 'This value is invalid',
            'password.required' => 'password field is required',
        ];
    }
}
