<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recompense extends Model
{
    use HasFactory;

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    protected $fillable = [
        'agent_id', 'type_recompense', 'date_recompense',
        'motif', 'statut', 'document'
    ];

    protected $casts = [
        'date_recompense' => 'datetime',
    ];

    protected $appends = [
        'recompense_summary', 'full_recompense_info', 'document_url'
    ];

    public function getTypeRecompenseAttribute($value) {
        return ucfirst($value);
    }

    public function getStatutAttribute($value) {
        return ucfirst($value);
    }

    public function getDateRecompenseAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function getMotifAttribute($value) {
        return $value ? ucfirst($value) : 'Aucun motif fourni';
    }

    public function scopeByAgent($query, $agentId) {
        return $query->where('agent_id', $agentId);
    }

    public function scopeByType($query, $type) {
        return $query->where('type_recompense', $type);
    }

    public function scopeByStatut($query, $statut) {
        return $query->where('statut', $statut);
    }

    public function scopeRecent($query) {
        return $query->orderBy('date_recompense', 'desc');
    }

    public function getFullRecompenseInfoAttribute() {
        return $this->agent ? $this->agent->nom . ' ' . $this->agent->prenom . ' - ' . $this->type_recompense . ' (' . $this->date_recompense . ') - ' . $this->motif : 'Aucune récompense disponible';
    }

    public function getRecompenseSummaryAttribute() {
        return $this->fullRecompenseInfo . ' - Statut: ' . $this->statut;
    }

    public function getDocumentUrlAttribute() {
        return $this->document ? asset('storage/' . $this->document) : null;
    }
}
