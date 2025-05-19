<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueAgent extends Model
{
    protected $table ='historique_agents';

    protected $fillable = [
       'id_agent', 'rattachement_type_id', 'rattachement_zone_id', 'type_collectivite', 'nom', 'prenom', 'contact_fonctionnaire', 'lieu_naiss', 'date_naiss', 'sexe', 'nationnalite', 'situation_matri', 'matricule', 'diplome_recrutement', 'diplome_obtenu', 'niveau_etude', 'date_integration', 'ref_acte_integration', 'date_titularisation', 'ref_acte_titularisation', 'date_service', 'date_probable_depart', 'emploi', 'cadre_fonctionnaire', 'fonction', 'statut', 'categorie', 'echelle', 'classe', 'echelon','format_initiale', 'diplome_formation' ,'position_collectivite', 'sous_activite', 'situa_particuliere', 'type_archivage', 'motif', 'id_user_create', 'id_user_update', 'id_user_delete', 'updated_date',
    ];
}
