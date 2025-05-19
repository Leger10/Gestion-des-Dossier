<?php

use App\Models\Direction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('directions')->insert([
        //     'secretariat_particulier' => 'Exemple de secretariat particulier',
        //     'saf' => 'Exemple de SAF',
        //     'ssecu' => 'Exemple de SSECU',
        //     'dt' => 'Exemple de DT',
        //     'dsi' => 'Exemple de DSI',
        //     'dig' => 'Exemple de DIG',
        //     'desf' => 'Exemple de DESF',
        //     'dasp' => 'Exemple de DASP',
        // ]);

        Direction::firstOrCreate([
            'secretariat_particulier' => 'Exemple de secretariat particulier',
            'saf' => 'Exemple de SAF',
            'ssecu' => 'Exemple de SSECU',
            'dt' => 'Exemple de DT',
            'dsi' => 'Exemple de DSI',
            'dig' => 'Exemple de DIG',
            'desf' => 'Exemple de DESF',
            'dasp' => 'Exemple de DASP',
        ]);
    }
}
