<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\RattachementTypesTableSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\DirectionServiceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class, // ✅ nom correct
            DirectionServiceSeeder::class,
            RattachementTypesTableSeeder::class,
        ]);
    }
}
