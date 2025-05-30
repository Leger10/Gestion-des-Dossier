<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Utilisation de firstOrCreate pour garantir que les rôles existent
        $adminRole = Role::firstOrCreate(['name' => 'Administrateur']);
        $superviseurRole = Role::firstOrCreate(['name' => 'Superviseur']);
        $agentRole = Role::firstOrCreate(['name' => 'Agent']);

        // Créer des utilisateurs avec des rôles spécifiques
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id
        ]);

        User::create([
            'name' => 'Superviseur User',
            'email' => 'superviseur@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => $superviseurRole->id
        ]);

        User::create([
            'name' => 'Agent User',
            'email' => 'agent@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => $agentRole->id
        ]);
    }
}


