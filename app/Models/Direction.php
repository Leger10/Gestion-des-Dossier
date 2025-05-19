<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
      protected $fillable = ['name']; // ✅ Ajoute ceci

    public function services()
    {
        return $this->hasMany(Service::class);
    }
    
public function agents()
{
    return $this->hasMany(Agent::class);
}
    public function users()
{
    return $this->hasMany(User::class);
}
}
