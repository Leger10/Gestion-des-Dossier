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
            'Lieu Naissance',
            'Date Naissance',
            'Situation Matrimoniale',
            'Niveau Recrutement',
            'Date Prise Service',
            'Emploi',
            'Fonction',
            'Statut',
            'Catégorie',
            'Grade',
            'Classe',
            'Echelon',
            'Direction',
            'Service',
            'Autorisation Absence',
            'Demande Congé',
            'Demande Explication',
            'Félicitation/Reconnaissance',
            'Sanctions',
            'Autre Situation'
        ];
    }

   public function map($agent): array
{
    // Vérifier que les relations sont bien chargées
    $directionName = ($agent->relationLoaded('direction') && $agent->direction) 
        ? $agent->direction->name 
        : ($agent->service && $agent->service->relationLoaded('direction') 
            ? $agent->service->direction->name 
            : 'Non spécifié');
    
    $serviceName = ($agent->relationLoaded('service') && $agent->service)
        ? $agent->service->name
        : 'Non spécifié';

    return [
        $agent->id,
        $agent->matricule,
        $agent->nom,
        $agent->prenom,
        $agent->sexe,
        $agent->lieu_naiss,
        $agent->date_naiss ? $agent->date_naiss->format('d/m/Y') : '',
        $agent->situation_matri,
        $agent->niveau_recrutement,
        $agent->date_prise_de_service ? $agent->date_prise_de_service->format('d/m/Y') : '',
        $agent->emploi,
        $agent->fonction,
        $agent->statut,
        $agent->categorie,
        $agent->grade,
        $agent->classe,
        $agent->echelon,
        $directionName,
        $serviceName,
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