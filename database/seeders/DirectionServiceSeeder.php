<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Direction;
use App\Models\Service;

class DirectionServiceSeeder extends Seeder
{
    public function run()
    {
        $directions = [
            [
                'name' => 'DGTI',
                'description' => 'Direction Générale des Transmissions et de l\'Information',
                'services' => [
                    ['name' => 'Secrétariat Particulier', 'short' => 'SP'],
                    ['name' => 'Service Administratif et Financier', 'short' => 'SAF'],
                    ['name' => 'Service de Sécurité', 'short' => 'SS']
                ]
            ],
            [
                'name' => 'DT',
                'description' => 'Direction des transmissions',
                'services' => [
                    ['name' => 'Service des transmissions radio', 'short' => 'STR'],
                    ['name' => 'Service de la téléphonie', 'short' => 'ST'],
                    ['name' => 'Service de vidéo protection', 'short' => 'SVP']
                ]
            ],
            [
                'name' => 'DSI',
                'description' => 'Direction des Systèmes d\'Information',
                'services' => [
                    ['name' => 'Service des Réseaux et Systèmes', 'short' => 'SRS'],
                    ['name' => 'Service ingénierie de développement', 'short' => 'SID'],
                    ['name' => 'Service de l\'exploitation et support', 'short' => 'SES'],
                    ['name' => 'Urbaniste des systèmes d\'information', 'short' => 'USI']
                ]
            ],
            [
                'name' => 'DESF',
                'description' => 'Direction des études, stratégie et formation',
                'services' => [
                    ['name' => 'Service des études et analyse technique', 'short' => 'SEAT'],
                    ['name' => 'Service de la formation professionnelle', 'short' => 'SFP'],
                    ['name' => 'Service de veille et innovation technologique', 'short' => 'SVIT']
                ]
            ],
            [
                'name' => 'DIG',
                'description' => 'Direction de l\'information géographique',
                'services' => [
                    ['name' => 'Service information géographique et télédétection', 'short' => 'SIGT'],
                    ['name' => 'Service production cartographique et géolocalisation', 'short' => 'SPCTG']
                ]
            ],
            [
                'name' => 'DASP',
                'description' => 'Direction administration et suivi des programmes',
                'services' => [
                    ['name' => 'Service programme planification et capitalisation', 'short' => 'SPPC'],
                    ['name' => 'Service qualité et sécurité des systèmes', 'short' => 'SQSS']
                ]
            ],
            [
                'name' => 'ARTI',
                'description' => 'Antennes régionales transmissions et informatique',
                'services' => [
                    ['name' => 'ARTI Nord', 'short' => 'ARTI-N'],
                    ['name' => 'ARTI Sud-ouest', 'short' => 'ARTI-SO'],
                    ['name' => 'ARTI Centre', 'short' => 'ARTI-C'],
                    ['name' => 'ARTI Centre-Ouest', 'short' => 'ARTI-CO'],
                     ['name' => 'ARTI Centre-Est', 'short' => 'ARTI-CE'],
                    ['name' => 'ARTI Est', 'short' => 'ARTI-E'],
                    ['name' => 'ARTI Centre-sud', 'short' => 'ARTI-CS'],
                    ['name' => 'ARTI Sahel', 'short' => 'ARTI-S'],
                    ['name' => 'ARTI Sud-est', 'short' => 'ARTI-SE'],
                    ['name' => 'ARTI Cascade', 'short' => 'ARTI-C'],
                    ['name' => 'ARTI Centre-nord', 'short' => 'ARTI-CN'],
                    ['name' => 'ARTI Plateau-centrale', 'short' => 'ARTI-PC'],
                     ['name' => 'ARTI Boucle-Mouhoun', 'short' => 'ARTI-BM']
                ]
            ]
        ];

        foreach ($directions as $directionData) {
            $direction = Direction::updateOrCreate(
                ['name' => $directionData['name']],
                ['description' => $directionData['description']]
            );

            if (isset($directionData['services'])) {
                foreach ($directionData['services'] as $serviceData) {
                    $direction->services()->updateOrCreate(
                        ['name' => $serviceData['name']],
                        ['short_name' => $serviceData['short']]
                    );
                }
            }
        }
    }
}