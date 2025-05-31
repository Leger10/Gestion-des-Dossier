<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActeAdministratif extends Model
{
    protected $fillable = [
        'agent_id',
        'type',
        'reference',
        'date_acte',
        'description'
    ];

    protected $casts = [
        'date_acte' => 'date'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    // Ajoutez cette méthode dans le modèle ActeAdministratif
public function documents()
{
    return $this->hasMany(Document::class);
}
}
