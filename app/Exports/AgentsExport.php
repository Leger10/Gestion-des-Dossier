<?php

namespace App\Exports;

use App\Models\Agent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class AgentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $agents;
 protected $query;

    public function __construct($agents, $query = null)
    {
        $this->agents = $agents;
        $this->query = $query;
    }

public function collection()
{
    return $this->agents instanceof Collection ? $this->agents : collect();
}


    

    public function headings(): array
    {
        return [
            'ID',
            'Matricule',
            'Nom',
            'Prénom',
            'Sexe',
            'lieu_naissance',
            'date_naissance',
            'situation_matrimoniale',
            'diplome_recrutement',
            'date_prise_de_service',
            'emploi',
            'fonction',
            'Statut',
            'Catégorie',
            'grade',
            'classe',
            'indice',
            'echelon',
            'Direction',
            'Service',
            'autorisation_absence',
            'demande_conge',
            'demande_explication',
            'felicitation_reconnaissance',
            'Sanctions',
            'Autre Situation'
        ];
    }

   public function map($agent): array
{
    // Méthode 1: Direction directe de l'agent
    $directionName = $agent->direction?->name;
    
    // Méthode 2: Direction via le service (si direction directe non disponible)
    if (!$directionName && $agent->service && $agent->service->relationLoaded('direction')) {
        $directionName = $agent->service->direction?->name;
    }
    
    // Méthode 3: Valeur par défaut
    $directionName = $directionName ?? 'Non spécifié';

    return [
        $agent->id,
        $agent->matricule,
        $agent->nom,
        $agent->prenom,
        $agent->sexe,
        $agent->lieu_naissance,
        $agent->date_naissance ? $agent->date_naissance->format('d/m/Y') : '',
        $agent->situation_matrimoniale,
        $agent->niveau_recrutement,
        $agent->date_prise_de_service ? $agent->date_prise_de_service->format('d/m/Y') : '',
        $agent->emploi,
        $agent->fonction,
        $agent->statut,
        $agent->categorie,
        $agent->grade,
        $agent->classe,
        $agent->indice,
        $agent->echelon,
        $directionName, // Direction maintenant correctement récupérée
        $agent->service?->name ?? 'Non spécifié',
        $agent->autorisation_absence,
        $agent->demande_conge,
        $agent->demande_explication,
        $agent->felicitation_reconnaissance,
        $agent->sanctions,
        $agent->autre_situation
    ];
}
    public function styles(Worksheet $sheet)
    {
        // Style pour les en-têtes
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ]
        ];

        // Style pour les bordures
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        // Appliquer les styles
        $sheet->getStyle('A1:Y1')->applyFromArray($headerStyle);
        $sheet->getStyle('A2:Y'.$sheet->getHighestRow())->applyFromArray($borderStyle);

        // Style conditionnel pour statut inactif
        $sheet->getStyle('M2:M'.$sheet->getHighestRow())
            ->getFont()
            ->getColor()
            ->setRGB('FF0000');

        // Auto-filtre
        $sheet->setAutoFilter('A1:Y1');

        return [];
    }
}