<?php

namespace App\Http\Controllers\PageParametre;

use App\Models\Agent;
use App\Models\Region;
use App\Models\Province;
use App\Models\Collectivite;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class StatistiqueController extends Chart
{
    public function statistiqueRegion ()
    {
        $regions = Region::all();
        $listeRegions = collect();
        $listeAgents  = collect();
        $nombreAgents  = collect();

        foreach ($regions  as $regions) {

                $listeAgentsDuneRegion = Agent::where('rattachement_type_id', 1)->where('rattachement_zone_id', $regions->id)->get();
                $listeRegions->push($regions->libelle);
                $listeAgents->push($listeAgentsDuneRegion);
        }
        $type_zone = 1;
        foreach ($listeAgents as $utilisateur) {
            $nombreAgents->push($utilisateur->count());
        }
        $chart = new StatistiqueController;

        $chart->labels($listeRegions);
        $chart->dataset('Agents', 'bar', $nombreAgents);


        return view('pages.statistique.statistiquesRegions', compact('chart', 'type_zone') );
    }

    public function statistiqueCommune ()
    {
        $collectivites = Collectivite::paginate(24);
        return view('pages.statistique.statistiqueCommune', compact('collectivites'));
    }
}
