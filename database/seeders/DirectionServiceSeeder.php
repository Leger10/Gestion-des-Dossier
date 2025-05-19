<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Direction;
use App\Models\Service;

class DirectionServiceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'DGTI' => ['Secretariat particulier', 'SAF', 'SSECU'],
            'DT'   => ['STR', 'ST', 'SVP'],
            'DSI'  => ['SRS', 'SID', 'SES', 'USI'],
            'DIG'  => ['SIGT', 'SPCTG'],
            'DESF' => ['SEAT', 'SFPP', 'SVIT'],
            'DASP' => ['SPPC', 'SQSSI'],
        ];

        foreach ($data as $directionName => $services) {
            $direction = Direction::firstOrCreate(['name' => $directionName]);

            foreach ($services as $serviceName) {
                Service::firstOrCreate([
                    'name' => $serviceName,
                    'direction_id' => $direction->id
                ]);
            }
        }
    }
}
