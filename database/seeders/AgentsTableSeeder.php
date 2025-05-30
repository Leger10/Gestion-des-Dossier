<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // database/seeders/AgentsTableSeeder.php
public function run()
{
    $directions = ['DGTI', 'DT', 'DSI', 'DASP', 'DSEF', 'DIG'];
    $categories = ['I', 'II', 'III', 'Néant'];
    
    foreach (range(1, 785) as $i) {
        Agent::create([
            'nom' => 'Nom'.$i,
            'prenom' => 'Prénom'.$i,
            'genre' => rand(0, 1) ? 'M' : 'F',
            'categorie' => $categories[array_rand($categories)],
            'direction' => $directions[array_rand($directions)],
            'service' => ($i % 2) ? 'Service'.rand(1,10) : null
        ]);
    }
}
}
