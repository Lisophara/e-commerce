<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * @throws \Throwable
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $this->call([
                UserSeeder::class,
                StoreSeeder::class,
            ]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }
}
