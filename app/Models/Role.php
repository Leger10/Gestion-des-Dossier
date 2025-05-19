<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Les attributs mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description' // Optionnel
    ];

    /**
     * Relation avec les utilisateurs
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Constantes pour les noms de rôles
     */
    public const ADMIN = 'Administrateur';
    public const SUPERVISEUR = 'Superviseur';
    public const AGENT = 'Agent';

    /**
     * Méthodes pour vérifier le type de rôle
     */
    public function isAdmin(): bool
    {
        return $this->name === self::ADMIN;
    }

    public function isSuperviseur(): bool
    {
        return $this->name === self::SUPERVISEUR;
    }

    public function isAgent(): bool
    {
        return $this->name === self::AGENT;
    }

    /**
     * Scope pour les requêtes courantes
     */
    public function scopeAdmins($query)
    {
        return $query->where('name', self::ADMIN);
    }

    public function scopeSuperviseurs($query)
    {
        return $query->where('name', self::SUPERVISEUR);
    }

    public function scopeAgents($query)
    {
        return $query->where('name', self::AGENT);
    }
}