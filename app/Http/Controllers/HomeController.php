<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Récupération des données de base
        $direction = Direction::with('agents')->get(); // Changé 'agents' en 'users'
        $service = Service::with('agents')->get(); // Changé 'agents' en 'users'
        
        // Données pour les tableaux détaillés
        $serviceHommes = Service::whereHas('agents', function($query) {
            $query->where('sexe', 'Masculin');
        })->get();

        $serviceFemmes = Service::whereHas('agents', function($query) {
            $query->where('sexe', 'Feminin');
        })->get();

        // Pour les directions
        $directionHommes = Direction::whereHas('agents', function($query) {
            $query->where('sexe', 'Masculin');
        })->get();

        $directionFemmes = Direction::whereHas('agents', function($query) {
            $query->where('sexe', 'Feminin');
        })->get();

        return view('pages.front-end.accueil', [
    'direction' => $direction,
    'service' => $service,
    'serviceHommes' => $serviceHommes,
    'serviceFemmes' => $serviceFemmes,
    'directionHommes' => $directionHommes,
    'directionFemmes' => $directionFemmes,
    'totalAgents' => Agent::count(),
    'totalHommes' => Agent::where('sexe', 'Masculin')->count(),
    'totalFemmes' => Agent::where('sexe', 'Feminin')->count(),
    'totalDirection' => $direction->count(),
    'totalService' => $service->count(),
]);
 }
  }