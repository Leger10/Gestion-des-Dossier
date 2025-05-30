<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActeAdministratif extends Model
{
    use HasFactory;
  
   protected $table = 'acte_administratifs';

    protected $fillable = [
        'agent_id',
        'type',
        'reference',
        'date_acte',
        'description',
    ];

 protected $dates = [
    'date_acte', 
    'created_at',
    'updated_at'
];

// OU avec $casts pour plus de contrôle
protected $casts = [
    'date_acte' => 'datetime:Y-m-d',
];
    public function getTypeAttribute($value) {
        return ucfirst($value);
    }

    public function getReferenceAttribute($value) {
        return strtoupper($value);
    }
    public function getDateActeAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
    public function getDescriptionAttribute($value) {
        return $value ? ucfirst($value) : 'Aucune description fournie';
    }
    public function agent()
{
    return $this->belongsTo(Agent::class);
}
}
