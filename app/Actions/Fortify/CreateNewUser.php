<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make(
            $input,
            [
                'name' => ['required', 'string', 'max:255'],

                'username' => [
                    'required',
                    'string',
                    'max:255',
                    'alpha_dash',
                    Rule::unique(User::class, 'username'),
                ],

                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class, 'email'),
                ],

                'password' => $this->passwordRules(),
            ],
            // 👇 CUSTOM MESSAGE
            [
                'name.required' => 'Nama wajib diisi.',
                'name.max'      => 'Nama maksimal 255 karakter.',

                'username.required'   => 'Username wajib diisi.',
                'username.alpha_dash' => 'Username hanya boleh huruf, angka, strip, dan underscore.',
                'username.unique'     => 'Username sudah digunakan.',

                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email sudah terdaftar.',

                'password.required'  => 'Password wajib diisi.',
                'password.min'       => 'Password minimal :min karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]
        )->validate();

        $user = User::create([
            'name'     => $input['name'],
            'username' => $input['username'],
            'email'    => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole('user');

        return $user;
    }
}
