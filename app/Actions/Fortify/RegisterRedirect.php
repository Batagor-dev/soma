<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterRedirect
{
    public function __invoke(Request $request)
    {
        // REGISTER PASTI USER
        return redirect('/');
    }
}
