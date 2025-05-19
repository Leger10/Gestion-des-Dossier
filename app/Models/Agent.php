<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;

    // Attributs remplissables
    protected $fillable = [
        'nom', 'prenom', 'lieu_naiss', 'date_naiss', 'sexe', 'situation_matri', 'matricule',
        'niveau_recrutement', 'date_prise_de_service', 'emploi', 'fonction', 'statut', 'categorie',
        'grade', 'classe', 'echelon', 'autorisation_absence', 'demande_conge', 'demande_explication',
        'felicitation_reconnaissance', 'sanctions', 'autre_situation', 'formInit', 'position', 'situationParti'
    ];

    // Attributs de type date
    protected $dates = ['deleted_at'];

    // Relation avec l'utilisateur qui a créé l'agent
    public function userCreate()
    {
        return $this->belongsTo('App\User', 'id_user_create', 'id');
    }

    // Relation avec l'utilisateur qui a mis à jour l'agent
    public function userUpdate()
    {
        return $this->belongsTo('App\User', 'id_user_update', 'id');
    }

    // Relation avec l'utilisateur qui a supprimé l'agent
    public function userDelete()
    {
        return $this->belongsTo('App\User', 'id_user_delete', 'id');
    }

    // Relation avec la direction (rattachement_zone)
    public function direction()
    {
        return $this->belongsTo('App\Models\Direction', 'rattachement_zone_id', 'id');
    }

    // Relation avec le service (rattachement_type)
    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'rattachement_type_id', 'id');
    }

    // Relation avec les dossiers associés à l'agent
    public function dossiers()
    {
        return $this->hasMany('App\Models\Dossier', 'agent_id', 'id');
    }
}
