<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Services\Auth\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        if (!$result) {
            return $this->errorResponse($result, 'login data incorrect.', 401);
        }

        return $this->successResponse([
            'user'  => $result['user'],
            'token' => $result['token'],
        ], 'user loged in successfuly');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());


        return $this->successResponse([
            'user'  => $result['user'],
            'token' => $result['token'],
        ], 'user registerd sccessfuly', 201);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $sent = $this->authService->forgotPassword($request->email);

        if (!$sent) {
            return $this->errorResponse(null, 'fail to send reset link', 500);
        }

        return $this->successResponse(null, 'Reset link sent correctly', 200);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $reset = $this->authService->resetPassword($request->validated());

        if (!$reset) {
            return $this->errorResponse(null,'Reset link expired ', 400);
        }

        return $this->successResponse(null, 'Password reset successfuly',200);
    }
}
