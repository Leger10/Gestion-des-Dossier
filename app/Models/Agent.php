<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Direction;
use App\Models\Service;
use App\Models\User;

class Agent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nom', 'prenom', 'lieu_naiss', 'date_naiss', 'sexe', 'situation_matri', 'matricule',
        'niveau_recrutement', 'date_prise_de_service', 'emploi', 'fonction', 'statut', 'categorie',
        'grade', 'classe', 'echelon', 'autorisation_absence', 'demande_conge', 'demande_explication',
        'felicitation_reconnaissance', 'sanctions', 'autre_situation', 'formInit', 'position', 'situationParti',
        'direction_id', 'service_id', 'rattachement_type_id', 'rattachement_zone_id', 'id_user_create',
        'id_user_update', 'id_user_delete'
    ];

    protected $casts = [
        'date_naiss' => 'date',
        'date_prise_de_service' => 'date',
        'deleted_at' => 'datetime'
    ];

    // Relation avec la direction
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    // Relation avec le service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relation polymorphique pour le rattachement
    public function rattachement()
    {
        return $this->morphTo(
            'rattachement', 
            'rattachement_type_id', 
            'rattachement_zone_id'
        );
    }

    // Relation avec l'utilisateur créateur
    public function userCreate()
    {
        return $this->belongsTo(User::class, 'id_user_create');
    }

    // Relation avec l'utilisateur modificateur
    public function userUpdate()
    {
        return $this->belongsTo(User::class, 'id_user_update');
    }

    // Relation avec l'utilisateur suppresseur
    public function userDelete()
    {
        return $this->belongsTo(User::class, 'id_user_delete');
    }

    // Relation avec les dossiers
    public function dossiers()
    {
        return $this->hasMany(dossier::class);
    }


    public function setDateNaissAttribute($value)
    {
        $this->attributes['date_naiss'] = \Carbon\Carbon::parse($value);
    }

    public function setDatePriseDeServiceAttribute($value)
    {
        $this->attributes['date_prise_de_service'] = \Carbon\Carbon::parse($value);
    }

    

    public function scopeHommes($query)
    {
        return $query->where('sexe', 'Masculin');
    }

    public function scopeFemmes($query)
    {
        return $query->where('sexe', 'Feminin');
    }
    // Accesseur pour le nom complet
public function getNomCompletAttribute()
{
    return $this->nom . ' ' . $this->prenom;
}

// Scope pour les agents actifs
public function scopeActifs($query)
{
    return $query->where('statut', 'Actif');
}
}