<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'agent_id',
        'acte_administratif_id',
        'nom',
        'chemin',
        'type',
        'taille',
        'description'
    ];

    /**
     * Relation avec l'agent
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Relation avec l'acte administratif
     */
    public function acteAdministratif(): BelongsTo
    {
        return $this->belongsTo(ActeAdministratif::class);
    }

    /**
     * URL complète du document
     */
    public function url(): string
    {
        return asset('storage/' . $this->chemin);
    }

    /**
     * Taille formatée
     */
    public function tailleFormatee(): string
    {
        $bytes = $this->taille;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}