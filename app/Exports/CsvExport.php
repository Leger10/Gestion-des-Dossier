<?php

namespace App\Exports;

use App\Models\Agent;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class CsvExport implements FromQuery, WithHeadings
{

    use Exportable;

    public function __construct(int $zoneId, string $localite)
    {
        $this->zoneId = $zoneId;
        $this->localite = $localite;
        // dd($localite);
    }
    /**
    * @return Builder
    */
    public function query()
    {
       if ($this->zoneId === 1) {
           switch ($this->localite) {
               case 'TOUTES LES REGIONS':
               return Agent
               ::query()
               ->join('regions','agents.rattachement_zone_id','=','regions.id')
               ->where('rattachement_type_id', '=', $this->zoneId)
               ->orderBy('regions.libelle', 'asc')
               ->select('agents.nom', 'agents.prenom', 'agents.contact_fonctionnaire', 'agents.lieu_naiss', 'agents.date_naiss', 'agents.sexe', 'agents.nationnalite', 'agents.situation_matri', 'agents.matricule', 'agents.diplome_recrutement', 'agents.date_integration', 'agents.ref_acte_integration', 'agents.date_titularisation', 'agents.ref_acte_titularisation', 'agents.date_service', 'agents.date_probable_depart', 'agents.emploi', 'agents.cadre_fonctionnaire', 'agents.fonction', 'agents.statut', 'agents.categorie', 'agents.echelle', 'agents.classe', 'agents.echelon','agents.format_initiale', 'agents.diplome_formation', 'agents.position_collectivite', 'agents.sous_activite', 'agents.situa_particuliere', 'regions.libelle',
                 \DB::raw('(CASE 

                            WHEN agents.diplome_formation = "Néant" THEN "Néant" 

                            ELSE agents.diplome_formation 

                            END) AS diplome_formation'),
            );   
                    break;
               default:
               return Agent
               ::query()
               ->join('regions','agents.rattachement_zone_id','=','regions.id')
               ->where('rattachement_type_id', '=', $this->zoneId)
               ->where('regions.id', '=', $this->localite)
               ->orderBy('regions.libelle', 'asc')
               ->select('agents.nom', 'agents.prenom', 'agents.contact_fonctionnaire', 'agents.lieu_naiss', 'agents.date_naiss', 'agents.sexe', 'agents.nationnalite', 'agents.situation_matri', 'agents.matricule', 'agents.diplome_recrutement', 'agents.date_integration', 'agents.ref_acte_integration', 'agents.date_titularisation', 'agents.ref_acte_titularisation', 'agents.date_service', 'agents.date_probable_depart', 'agents.emploi', 'agents.cadre_fonctionnaire', 'agents.fonction', 'agents.statut', 'agents.categorie', 'agents.echelle', 'agents.classe', 'agents.echelon','agents.format_initiale', 'agents.diplome_formation', 'agents.position_collectivite', 'agents.sous_activite', 'agents.situa_particuliere', 'regions.libelle',
                 \DB::raw('(CASE 

                            WHEN agents.diplome_formation = "Néant" THEN "Néant" 

                            ELSE agents.diplome_formation 

                            END) AS diplome_formation'),
            );
                   break;
           }
       
       } else {
           switch ($this->localite) {
               case 'TOUTES LES COMMNUNES':
               return Agent
               ::query()
               ->join('collectivites','agents.rattachement_zone_id','=','collectivites.id')
               ->where('rattachement_type_id', '=', $this->zoneId)
               ->orderBy('collectivites.libelle', 'asc')
               ->select('agents.nom', 'agents.prenom', 'agents.contact_fonctionnaire', 'agents.lieu_naiss', 'agents.date_naiss', 'agents.sexe', 'agents.nationnalite', 'agents.situation_matri', 'agents.matricule', 'agents.diplome_recrutement', 'agents.date_integration', 'agents.ref_acte_integration', 'agents.date_titularisation', 'agents.ref_acte_titularisation', 'agents.date_service', 'agents.date_probable_depart', 'agents.emploi', 'agents.cadre_fonctionnaire', 'agents.fonction', 'agents.statut', 'agents.categorie', 'agents.echelle', 'agents.classe', 'agents.echelon','agents.format_initiale', 'agents.diplome_formation', 'agents.position_collectivite', 'agents.sous_activite', 'agents.situa_particuliere', 'collectivites.libelle',
                \DB::raw('(CASE 

                            WHEN collectivites.type_collectivite = "1" THEN "Rurale" 

                            ELSE "Urbaine" 

                            END) AS type_collectivite'),
                \DB::raw('(CASE 

                            WHEN collectivites.staut_type_collectivite = "1" THEN "Néant" 

                            ELSE "Statut particulier" 

                            END) AS staut_type_collectivite'),
                \DB::raw('(CASE 

                            WHEN agents.diplome_formation = "Néant" THEN "Néant" 

                            ELSE agents.diplome_formation 

                            END) AS diplome_formation'),          
                
                 );
                break;

               default:
               return Agent
               ::query()
               ->join('collectivites','agents.rattachement_zone_id','=','collectivites.id')
               ->where('rattachement_type_id', '=', $this->zoneId)
               ->where('collectivites.id', '=', $this->localite)
               ->orderBy('collectivites.libelle', 'asc')
               ->select('agents.nom', 'agents.prenom', 'agents.contact_fonctionnaire', 'agents.lieu_naiss', 'agents.date_naiss', 'agents.sexe', 'agents.nationnalite', 'agents.situation_matri', 'agents.matricule', 'agents.diplome_recrutement', 'agents.date_integration', 'agents.ref_acte_integration', 'agents.date_titularisation', 'agents.ref_acte_titularisation', 'agents.date_service', 'agents.date_probable_depart', 'agents.emploi', 'agents.cadre_fonctionnaire', 'agents.fonction', 'agents.statut', 'agents.categorie', 'agents.echelle', 'agents.classe', 'agents.echelon','agents.format_initiale', 'agents.diplome_formation', 'agents.position_collectivite', 'agents.sous_activite', 'agents.situa_particuliere', 'collectivites.libelle',
               \DB::raw('(CASE 

                            WHEN collectivites.type_collectivite = "1" THEN "Rurale" 

                            ELSE "Urbaine" 

                            END) AS type_collectivite'),
                \DB::raw('(CASE 

                            WHEN collectivites.staut_type_collectivite = "1" THEN "Néant" 

                            ELSE "Statut particulier" 

                            END) AS staut_type_collectivite'),
                \DB::raw('(CASE 

                            WHEN agents.diplome_formation = "Néant" THEN "Néant" 

                            ELSE agents.diplome_formation 

                            END) AS diplome_formation'),
             );
                break;
           }
       }
       

    }

    // /**
    // * @return \Illuminate\Support\Collection
    // */

    public function headings(): array
    {
        if ( $this->zoneId === 1 ) {
            return[
                'Nom',
                'Prenom',
                'Contact',
                'Lieu de naissance',
                'Date de naissance',
                'Sexe',
                'Nationalité',
                'Situation matrimoniale',
                'Matricule',
                'Diplome de recrutement',
                'Date d\'integration',
                'Références Acte Intégration',
                'Date de titularisation',
                'Références Acte Titularisation',
                'Date de prise de service',
                'Date probable départ retraite',
                'Emploi',
                'Cadre des fonctionnaires',
                'Fonction',
                'Statut',
                'Catégorie',
                'Echelle',
                'Niveau d\'étude',
                'Echelon',
                'Formation initiale',
                'Diplôme obtenu à l\'issue de la formation initiale',
                'Position dans la collectivité',
                'Etat d\'activité',
                'Situation particulière',
                'Localité',
               
        ];
        } else {
           return[
                'Nom',
                'Prenom',
                'Contact',
                'Lieu de naissance',
                'Date de naissance',
                'Sexe',
                'Nationalité',
                'Situation matrimoniale',
                'Matricule',
                'Diplome de recrutement',
                'Date d\'integration',
                'Références Acte Intégration',
                'Date de titularisation',
                'Références Acte Titularisation',
                'Date de prise de service',
                'Date probable départ retraite',
                'Emploi',
                'Cadre des fonctionnaires',
                'Fonction',
                'Statut',
                'Catégorie',
                'Echelle',
                'Niveau d\'étude',
                'Echelon',
                'Formation initiale',
                'Diplôme obtenu à l\'issue de la formation initiale',
                'Position dans la collectivité',
                'Etat d\'activité',
                'Situation particulière',
                'Localité',
                'Type collectivité',
                'Statut collectivité',
               
        ];
        }
        
        
    }
}
