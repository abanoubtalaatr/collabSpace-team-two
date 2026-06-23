<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
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
}
