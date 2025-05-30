<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RattachementType extends Model
{
    protected $fillable = ['name'];
     public $timestamps = true;
    // Relation si nécessaire
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}