<?php

namespace Database\Seeders;

use App\Enum\Gender;
use App\Enum\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run() {
        // Admin
        User::create([
            'email' => 'admin',
            'password' => Hash::make('admin'),
            'first_name' => 'Administrator',
            'last_name' => '',
            'phone' => '0962031234',
            'type' => UserType::ADMIN,
            'gender' => Gender::MALE,
            'day_of_birth' => '2001-01-01',
            'active' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Merchant
        User::create([
            'email' => 'merchant',
            'password' => Hash::make('merchant'),
            'first_name' => 'Merchant',
            'last_name' => '',
            'phone' => '0962031234',
            'type' => UserType::MERCHANT,
            'gender' => Gender::MALE,
            'day_of_birth' => '2001-01-01',
            'active' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
