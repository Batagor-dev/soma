<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): Response
    {
        $user = $request->user();

        // 🚨 WAJIB: cek verifikasi email dulu
        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if ($user->banned_at) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda telah diblokir.']);
        }


        // ADMIN / SUPER ADMIN
        if ($user->hasRole(['Super Admin', 'Admin'])) {
            return redirect()->route('dashboard');
        }

        // USER BIASA
        return redirect()->route('home');
    }
}
