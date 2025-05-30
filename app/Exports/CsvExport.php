<?php

namespace App\Exports;

use App\Models\Agent;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class CsvExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected int $exportType;
    protected $identifier;

    public function __construct(int $exportType, $identifier)
    {
        $this->exportType = $exportType; // 1=region, 2=direction, 3=service
        $this->identifier = $identifier;
    }

    public function query()
    {
        $query = Agent::query()
            ->with(['direction', 'service'])
            ->orderBy('nom');

        switch ($this->exportType) {
            case 1: // Export par région (si applicable)
                return $query->where('rattachement_type_id', 1)
                    ->when($this->identifier !== 'TOUTES LES Agents', function($q) {
                        $q->where('rattachement_zone_id', $this->identifier);
                    });

            case 2: // Export par direction
                return $query->when($this->identifier !== 'TOUTES LES DIRECTIONS', function($q) {
                    $q->where('direction_id', $this->identifier);
                });

            case 3: // Export par service
                return $query->when($this->identifier !== 'TOUS LES SERVICES', function($q) {
                    $q->where('service_id', $this->identifier);
                });

            default:
                return $query->limit(0);
        }
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'Sexe',
            'Lieu de naissance',
            'Date de naissance',
            'Situation matrimoniale',
            'Matricule',
            'Niveau de recrutement',
            'Date de prise de service',
            'Emploi',
            'Fonction',
            'Statut',
            'Catégorie',
            'Grade',
            'Classe',
            'Echelon',
            'Direction',
            'Service',
            'Autorisation absence',
            'Demande congé',
            'Demande explication',
            'Félicitation/reconnaissance',
            'Sanctions',
            'Autre situation'
        ];
    }

    public function map($agent): array
    {

        // Chargez les relations si elles ne sont pas déjà chargées
    if (!$agent->relationLoaded('direction')) {
        $agent->load('direction');
    }
    if (!$agent->relationLoaded('service')) {
        $agent->load('service');
    }
        // Formatez les données pour l'exportation

        return [
            $agent->nom,
            $agent->prenom,
            $agent->sexe,
            $agent->lieu_naiss,
            $agent->date_naiss->format('d/m/Y'),
            $agent->situation_matri,
            $agent->matricule,
            $agent->niveau_recrutement,
            $agent->date_prise_de_service->format('d/m/Y'),
            $agent->emploi,
            $agent->fonction,
            $agent->statut,
            $agent->categorie,
            $agent->Grade,
            $agent->classe,
            $agent->echelon,
            $agent->direction->name ?? '',
            $agent->service->name ?? '',
            $agent->autorisation_absence,
            $agent->demande_conge,
            $agent->demande_explication,
            $agent->felicitation_reconnaissance,
            $agent->sanctions,
            $agent->autre_situation
        ];
    }


    
}