<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'libelle',
    ];

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function communes()
    {
        return $this->hasMany('App\Models\Collectivite');
    }
}
