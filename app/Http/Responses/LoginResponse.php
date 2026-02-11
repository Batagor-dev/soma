<?php
namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): JsonResponse
    {
        $token = auth('api')->login(Auth::user());

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'user' => Auth::user(),
            'token' => $token,
            'type' => 'bearer'
        ]);
    }
}
