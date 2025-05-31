<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
   protected $fillable = ['name',  'description','direction_id'];

   
public function direction()
{
    return $this->belongsTo(Direction::class);
}

// ✅ Définir la relation avec les utilisateurs
public function agents()
{
    return $this->hasMany(Agent::class); // ou Agent::class si tu as un modèle spécifique
}
public function agentsActifs()
{
    return $this->hasMany(Agent::class)->actifs();
}

public function children()
{
    return $this->hasMany(Direction::class, 'parent_id');
}

}
