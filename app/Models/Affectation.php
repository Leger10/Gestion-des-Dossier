<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;
    public function agent() {
    return $this->belongsTo(Agent::class);
}
    protected $fillable = [
        'agent_id', 'direction_id', 'service_id', 'date_affectation', 'type_affectation'
    ];

    protected $casts = [
        'date_affectation' => 'datetime',
    ];

    public function getTypeAffectationAttribute($value) {
        return ucfirst($value);
    }

    public function getDateAffectationAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
    public function direction() {
        return $this->belongsTo(Direction::class);
    }
    public function service() {
        return $this->belongsTo(Service::class);
    }
    public function getDirectionNameAttribute() {
        return $this->direction ? $this->direction->name : 'Aucune direction';
    }
    public function getServiceNameAttribute() {
        return $this->service ? $this->service->name : 'Aucun service';
    }
    public function getAgentNameAttribute() {
        return $this->agent ? $this->agent->nom . ' ' . $this->agent->prenom : 'Aucun agent';
    }
    public function getFullAffectationInfoAttribute() {
        return $this->agentName . ' - ' . $this->directionName . ' - ' . $this->serviceName . ' (' . $this->type_affectation . ')';
    }
    public function scopeRecent($query) {
        return $query->orderBy('date_affectation', 'desc');
    }
    public function scopeByAgent($query, $agentId) {
        return $query->where('agent_id', $agentId);
    }
    public function scopeByDirection($query, $directionId) {
        return $query->where('direction_id', $directionId);
    }
    public function scopeByService($query, $serviceId) {
        return $query->where('service_id', $serviceId);
    }
    public function scopeByType($query, $type) {
        return $query->where('type_affectation', $type);
    }
    public function scopeActive($query) {
        return $query->whereNull('date_fin');
    }
}
