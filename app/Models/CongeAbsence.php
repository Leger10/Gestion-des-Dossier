<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongeAbsence extends Model
{
    use HasFactory;

    protected $table = 'conge_absences';

    protected $fillable = [
        'agent_id',
        'type',
        'date_debut',
        'date_fin',
        'motif',
        'document',
    ];


    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    public function getTypeAttribute($value) {
        return ucfirst($value);
    }

    public function getDateDebutAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function getDateFinAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function getMotifAttribute($value) {
        return $value ? ucfirst($value) : 'Aucun motif fourni';
    }

    public function getDocumentUrlAttribute() {
        return $this->document ? asset('storage/' . $this->document) : null;
    }

    // Scopes

    public function scopeByAgent($query, $agentId) {
        return $query->where('agent_id', $agentId);
    }

    public function scopeByType($query, $type) {
        return $query->where('type', $type);
    }

    public function scopeRecent($query) {
        return $query->orderBy('date_debut', 'desc');
    }
}
