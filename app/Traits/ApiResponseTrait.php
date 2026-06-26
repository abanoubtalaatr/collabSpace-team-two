<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function successResponse(mixed $data = null, string $message = 'success', int $code = 200)
    {
        return response()->json([
            'status'  => $code,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public function errorResponse(mixed $errors = null, string $message = 'error ', int $code = 400)
    {
        return response()->json([
            'status'  => $code,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}
