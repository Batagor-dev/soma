<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Illuminate\Http\JsonResponse;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request): JsonResponse
    {
        $user = $request->user();

        $token = auth('api')->login($user);

        return response()->json([
            'status' => true,
            'message' => 'Register berhasil',
            'user' => $user,
            'token' => $token,
            'type' => 'bearer'
        ]);
    }
}
