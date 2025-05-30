<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Agent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'date_naissance',
        'lieu_naissance',
        'sexe',

        'situation_matrimoniale',
        'matricule',
        'nationalite',
        'date_recrutement',
        'diplome_recrutement',
        'statut',
        'position',
        'grade',
        'categorie',
        'echelon',
        'indice',
        'date_prise_de_service',
        'type_affectation',
        'position_agents',
        'position_service',
        'direction_id',
        'service_id',
        'id_user_create',
        'id_user_update',
        'id_user_delete'
    ];

    protected $casts = [
        'date_naissance' => 'datetime',
        'date_recrutement' => 'datetime',
        'date_prise_de_service' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function userCreate()
    {
        return $this->belongsTo(User::class, 'id_user_create');
    }

    public function userUpdate()
    {
        return $this->belongsTo(User::class, 'id_user_update');
    }

    public function userDelete()
    {
        return $this->belongsTo(User::class, 'id_user_delete');
    }

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    public function actes_administratifs()
    {
        return $this->hasMany(ActeAdministratif::class);
    }


    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function sanctions()
    {
        return $this->hasMany(Sanction::class);
    }


    // Accesseurs utiles
    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
    public function recompenses()
    {
        return $this->hasMany(Recompense::class);
    }

    public function conge_absences()
    {
        return $this->hasMany(CongeAbsence::class);
    }


    public function formations()
    {
        return $this->hasMany(Formation::class);
    }

    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getNomCompletAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
    public function getStatutClasseAttribute()
    {
        $classes = [
            'Actif' => 'success',
            'En congé' => 'warning',
            'Détaché' => 'info',
            'Archivé' => 'danger',
        ];

        return $classes[$this->statut] ?? 'default';
    }

    public function getEffectiveDirectionAttribute()
    {
        return $this->service ? $this->service->direction : $this->direction;
    }

    /*
    |--------------------------------------------------------------------------
    | Mutateurs
    |--------------------------------------------------------------------------
    */

    public function setDateNaissanceAttribute($value)
    {
        $this->attributes['date_naissance'] = Carbon::parse($value);
    }

    public function setDatePriseDeServiceAttribute($value)
    {
        $this->attributes['date_prise_de_service'] = $value ? Carbon::parse($value) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActifs($query)
    {
        return $query->where('statut', 'Actif');
    }

    public function scopeHommes($query)
    {
        return $query->where('sexe', 'M');
    }

    public function scopeFemmes($query)
    {
        return $query->where('sexe', 'F');
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Events (Soft Delete override)
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::deleting(function ($agent) {
            $agent->is_archived = true;
            $agent->save();
        });
    }
}
