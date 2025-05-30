<?php

namespace App\Http\Controllers\PageParametre;

use App\Models\Agent;
use App\Models\Region;
use App\Models\Province;
use App\Models\Collectivite;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Direction;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class StatistiqueController extends Chart
{
    public function statistiqueDirection()
    {
        $directions = Direction::all(); // Region devient direction ici
        $listeDirections = collect();
        $listeAgents  = collect();
        $nombreAgents  = collect();

        foreach ($directions as $direction) {
            $agentsParDirection = Agent::where('rattachement_type_id', 1)
                ->where('rattachement_zone_id', $direction->id)
                ->get();

            $listeDirections->push($direction->libelle);
            $listeAgents->push($agentsParDirection);
        }

        $type_zone = 1;

        foreach ($listeAgents as $utilisateur) {
            $nombreAgents->push($utilisateur->count());
        }

        $chart = new StatistiqueController;
        $chart->labels($listeDirections);
        $chart->dataset('Agents', 'bar', $nombreAgents);

        return view('pages.statistique.statistiquesDirections', compact('chart', 'type_zone'));
    }

    public function statistiqueService()
    {
        $services = Collectivite::paginate(24); // Collectivite = Service
        return view('pages.statistique.statistiquesServices', compact('services'));
    }
}
