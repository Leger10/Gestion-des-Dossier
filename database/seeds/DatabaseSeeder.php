<?php

use App\Models\Direction;
use Database\Seeders\DirectionServiceSeeder;
use Database\Seeders\RattachementTypesTableSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Database\Seeders\UsersTableSeeder;

class DirectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
//    public function run()
//     {
//         // Désactive la vérification des clés étrangères pendant le seeding
//         \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
//         // Appelle les seeders individuels
//         $this->call([
//             DirectionsSeeder::class,
//             // Ajoutez ici vos autres seeders
//              RoleSeeder::class,
//             UsersTableSeeder::class,
//             DirectionServiceSeeder::class,
//             RattachementTypesTableSeeder::class,
//             // etc...
//         ]);
        
//         // Réactive la vérification des clés étrangères
//         \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//     }
    }