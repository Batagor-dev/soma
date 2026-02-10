<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);

        $adminsuper = User::create([
            'username' => 'farel',
            'name' => 'tagor',
            'email' => 'techareaproduction@gmail.com',
            'email_verified_at' => '2022-08-16 20:57:19',
            'password' => Hash::make('#Tech7127#')
        ]);

        $adminsuper->assignRole('Super Admin');

        $adminsuper = User::create([
            'username' => 'admin',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => '2022-08-16 20:57:19',
            'password' => Hash::make('#Admin7127#')
        ]);

        $adminsuper->assignRole('Super Admin');

        $user = User::create([
            'username' => 'user',
            'name' => 'User',
            'email' => 'user@gmail.com',
            'email_verified_at' => '2022-08-16 20:57:19',
            'password' => Hash::make('#uUseq134#')
        ]);

        $user->assignRole('User');

      
        $this->call(MenuSeeder::class);
    }
}
