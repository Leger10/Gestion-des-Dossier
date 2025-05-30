<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    public function agent() {
        return $this->belongsTo(Agent::class);
    }

    protected $fillable = [
        'agent_id', 'intitule', 'date_debut', 'date_fin',
        'organisme', 'lieu', 'duree', 'statut', 'description', 'attestation'
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    protected $appends = [
        'formation_summary', 'formation_details', 'agent_name'
    ];

    public function getIntituleAttribute($value) {
        return ucfirst($value);
    }

    public function getStatutAttribute($value) {
        return ucfirst($value);
    }

    public function getDateDebutAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function getDateFinAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function getDureeAttribute($value) {
        return $value ? $value . ' heures' : 'Durée non spécifiée';
    }

    public function getOrganismeAttribute($value) {
        return $value ? ucfirst($value) : 'Organisme non spécifié';
    }

    public function getLieuAttribute($value) {
        return $value ? ucfirst($value) : 'Lieu non spécifié';
    }

    public function getAgentNameAttribute() {
        return $this->agent ? $this->agent->nom . ' ' . $this->agent->prenom : 'Aucun agent';
    }

    public function getFullFormationInfoAttribute() {
        return $this->agent ? $this->agent->nom . ' ' . $this->agent->prenom . ' - ' . $this->intitule . ' (' . $this->date_debut . ' - ' . $this->date_fin . ') - ' . $this->duree : 'Aucune formation disponible';
    }

    public function getFormationSummaryAttribute() {
        return $this->fullFormationInfo . ' - Organisme: ' . $this->organisme . ' - Lieu: ' . $this->lieu . ' - Statut: ' . $this->statut;
    }

    public function getFormationDetailsAttribute() {
        return $this->agentName . ' - ' . $this->intitule . ' - ' . $this->date_debut . ' à ' . $this->date_fin . ' - Durée: ' . $this->duree . ' - Organisme: ' . $this->organisme . ' - Lieu: ' . $this->lieu;
    }

    public function scopeByAgent($query, $agentId) {
        return $query->where('agent_id', $agentId);
    }

    public function scopeByStatut($query, $statut) {
        return $query->where('statut', $statut);
    }

    public function scopeRecent($query) {
        return $query->orderBy('date_debut', 'desc');
    }

    // URL d'accès à l'attestation
    public function getAttestationUrlAttribute() {
        return $this->attestation ? asset('storage/' . $this->attestation) : null;
    }
}
