<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@bookmart.test');
        $name = env('ADMIN_NAME', 'BookMart Admin');
        $password = env('ADMIN_PASSWORD', 'admin12345');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password, // hashed by User::$casts['password']
                'role' => 'admin',
                'remember_token' => Str::random(10),
            ]
        );
    }
}

