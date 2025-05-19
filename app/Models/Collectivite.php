<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collectivite extends Model
{
    protected $fillable = [
        'id','libelle',
         'agents',  // Nouveau nom de la table
    ];

    public function agents()
    {
        return $this->hasMany('App\Models\Agent', 'rattachement_zone_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Province');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province');
    }
}
