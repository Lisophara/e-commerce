<?php

namespace Database\Seeders;

use App\Enum\Gender;
use App\Enum\UserType;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    public function run() {
        // Admin
        $admin = User::where('email', 'admin')->first();
        Store::create([
            'name' => 'AdminStore',
            'name_slug' => 'admin-store',
            'user_id' => $admin->id
        ]);
    }
}
