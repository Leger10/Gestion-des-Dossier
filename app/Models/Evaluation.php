<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    public function agent() {
    return $this->belongsTo(Agent::class);
}
    protected $fillable = [
        'agent_id', 'date_evaluation', 'note', 'commentaire', 'evaluateur_id'
    ];

    protected $casts = [
        'date_evaluation' => 'datetime',
    ];

    public function getDateEvaluationAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }

    public function evaluateur() {
        return $this->belongsTo(User::class, 'evaluateur_id');
    }

    public function scopeByAgent($query, $agentId) {
        return $query->where('agent_id', $agentId);
    }

    public function scopeRecent($query) {
        return $query->orderBy('date_evaluation', 'desc');
    }
    public function getNoteAttribute($value) {
        return $value ? round($value, 2) : 'Aucune note attribuée';
    }
    public function getCommentaireAttribute($value) {
        return $value ? ucfirst($value) : 'Aucun commentaire fourni';
    }
    public function getEvaluateurNameAttribute() {
        return $this->evaluateur ? $this->evaluateur->name : 'Evaluateur inconnu';
    }
    public function getFullEvaluationInfoAttribute() {
        return $this->agent ? $this->agent->nom . ' ' . $this->agent->prenom . ' - ' . $this->date_evaluation . ' - Note: ' . $this->note : 'Aucune évaluation disponible';
    }
    public function getEvaluateurInfoAttribute() {
        return $this->evaluateur ? $this->evaluateur->name . ' (' . $this->evaluateur->email . ')' : 'Aucun évaluateur';
    }
    public function getEvaluationSummaryAttribute() {
        return $this->fullEvaluationInfo . ' - Evalué par: ' . $this->evaluateurInfo;
    }
}
