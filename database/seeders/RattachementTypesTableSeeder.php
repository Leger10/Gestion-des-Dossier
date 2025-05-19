<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RattachementTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rattachement_types')->insert([
            ['name' => 'Direction'],
            ['name' => 'Service'],
        ]);
    }
}
