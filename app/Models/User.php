<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sexe',
        'service_id',
        'direction_id',
        'role_id' // Ajouté pour permettre l'assignation
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relation avec le modèle Role
     */

    /**
     * Vérifie si l'utilisateur est administrateur
     */
    // Dans app/Models/User.php
public function isAdmin()
{
    return $this->role === 'admin'; // Adaptez selon votre logique de rôle
}

    /**
     * Vérifie si l'utilisateur est superviseur
     */
    public function isSuperviseur(): bool
    {
        return $this->role->name === 'Superviseur';
    }

    /**
     * Vérifie si l'utilisateur est agent
     */
    public function isAgent(): bool
    {
        return $this->role->name === 'Agent';
    }

    /**
     * Vérifie si l'utilisateur a un rôle spécifique
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role->name === $roleName;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function agents()
{
    return $this->hasMany(Agent::class);
}
}
