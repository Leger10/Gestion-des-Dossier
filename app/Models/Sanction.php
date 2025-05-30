<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanction extends Model
{
    use HasFactory;

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    protected $fillable = [
        'agent_id', 'type_sanction', 'date_sanction', 'motif', 'statut', 'document'
    ];

    protected $casts = [
        'date_sanction' => 'datetime',
    ];

    protected $appends = [
        'sanction_summary', 'sanction_details', 'agent_name', 'document_url'
    ];

    public function getTypeSanctionAttribute($value) {
        return ucfirst($value);
    }

    public function getStatutAttribute($value) {
        return ucfirst($value);
    }

    public function getDateSanctionAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function getMotifAttribute($value) {
        return $value ? ucfirst($value) : 'Aucun motif fourni';
    }

    public function getFullSanctionInfoAttribute() {
        return $this->agent ? $this->agent->nom . ' ' . $this->agent->prenom . ' - ' . $this->type_sanction . ' (' . $this->date_sanction . ') - ' . $this->motif : 'Aucune sanction disponible';
    }

    public function getSanctionSummaryAttribute() {
        return $this->fullSanctionInfo . ' - Statut: ' . $this->statut;
    }

    public function getSanctionDetailsAttribute() {
        return $this->agent ? $this->agent->nom . ' ' . $this->agent->prenom . ' - ' . $this->type_sanction . ' - ' . $this->date_sanction : 'Aucun détail de sanction disponible';
    }

    public function getAgentNameAttribute() {
        return $this->agent ? $this->agent->nom . ' ' . $this->agent->prenom : 'Aucun agent';
    }

    public function getSanctionTypeAttribute() {
        return $this->type_sanction ? ucfirst($this->type_sanction) : 'Type de sanction non spécifié';
    }

    public function getSanctionDateAttribute() {
        return $this->date_sanction ? \Carbon\Carbon::parse($this->date_sanction)->format('d/m/Y') : 'Date de sanction non spécifiée';
    }

    public function getSanctionMotifAttribute() {
        return $this->motif ? ucfirst($this->motif) : 'Aucun motif de sanction spécifié';
    }

    public function getDocumentUrlAttribute() {
        return $this->document ? asset('storage/' . $this->document) : null;
    }

    // Scopes
    public function scopeByAgent($query, $agentId) {
        return $query->where('agent_id', $agentId);
    }

    public function scopeByType($query, $type) {
        return $query->where('type_sanction', $type);
    }

    public function scopeByStatut($query, $statut) {
        return $query->where('statut', $statut);
    }

    public function scopeRecent($query) {
        return $query->orderBy('date_sanction', 'desc');
    }
}
