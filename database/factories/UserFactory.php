<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;  // Importer la classe Str

class UserFactory extends Factory
{
    // Définit le modèle associé à la factory
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // ou un autre mot de passe
            'remember_token' => Str::random(10),  // Utilisation de la classe Str
        ];
    }
}
