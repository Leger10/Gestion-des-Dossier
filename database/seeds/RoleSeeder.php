<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Liste des rôles à insérer
        $roles = [
            ['name' => 'Administrateur'],
            ['name' => 'Superviseur'],
            ['name' => 'Agent']
        ];

        // Insertion ou récupération des rôles
        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}

