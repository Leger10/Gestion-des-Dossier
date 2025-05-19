<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User; // Assurez-vous d'importer votre modèle User
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Récupération des rôles
        $adminRole = Role::where('name', 'Administrateur')->first();
        $supervisorRole = Role::where('name', 'Superviseur')->first();
        $agentRole = Role::where('name', 'Agent')->first();

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('dgti@2025'),
                'role_id' => $adminRole->id,
            ]
        );

        // Superviseur
        User::firstOrCreate(
            ['email' => 'superviseur@gmail.com'],
            [
                'name' => 'Superviseur User',
                'password' => Hash::make('dgti@2025'),
                'role_id' => $supervisorRole->id,
            ]
        );

        // Agent
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Secretary User',
                'password' => Hash::make('dgti@2025'),
                'role_id' => $agentRole->id,
            ]
        );
    }
}
