<?php

namespace App\Http\Controllers\PageParametre;

use App\Models\Agent;
use App\Models\Direction;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{



    public function getDirectionsWithServices()
{
    return [
        'DGTI' => ['Secrétariat particulier', 'SAF', 'SSECU'],
        'DT' => ['STR', 'ST', 'SVP'],
        'DSI' => ['SRS', 'SID', 'SES', 'USI'],
        'DIG' => ['SIGT', 'SPCTG'],
        'DESF' => ['SEAT', 'SFPP', 'SVIT'],
        'DASP' => ['SPPC', 'SQSSI']
    ];
}

public function index()
{
    $direction = Direction::all(); // ou votre requête pour récupérer les directions
    $service = Service::all(); // ou votre requête pour récupérer les services
    
    return view('pages.front-end.accueil', compact('direction', 'service'));
}
  public function accueil()
{
    // Récupération paginée des agents
    $agents = Agent::whereNull('deleted_at')->paginate(24);

    // Données de base
    $direction = Agent::where('rattachement_type_id', 1)->whereNull('deleted_at')->get();
    $service = Agent::where('rattachement_type_id', 2)->whereNull('deleted_at')->get();

    // Statistiques globales
    $totalAgents = $agents->total(); // Utilise ->total() pour le total de la pagination
    $totalHommes = $agents->where('sexe', 'Masculin')->count();
    $totalFemmes = $agents->where('sexe', 'Feminin')->count();

    // Statistiques par type
    $totalDirection = $direction->count();
    $directionHommes = $direction->where('sexe', 'Masculin')->count();
    $directionFemmes = $direction->where('sexe', 'Feminin')->count();

    $totalService = $service->count();
    $serviceHommes = $service->where('sexe', 'Masculin')->count();
    $serviceFemmes = $service->where('sexe', 'Feminin')->count();

    // Si tu as une fonction pour grouper les agents par direction/service
    $directionsServices = $this->getDirectionsWithServices();

    // Envoi à la vue
    return view('pages.back-office-agent.accueil', [
        'agents' => $agents,
        'totalAgents' => $totalAgents,
        'totalHommes' => $totalHommes,
        'totalFemmes' => $totalFemmes,

        'totalDirection' => $totalDirection,
        'directionHommes' => $directionHommes,
        'directionFemmes' => $directionFemmes,

        'totalService' => $totalService,
        'serviceHommes' => $serviceHommes,
        'serviceFemmes' => $serviceFemmes,

        'directionsServices' => $directionsServices,
        'directionAgents' => $direction,
        'serviceAgents' => $service,
    ]);
}

    public function agentIndex()
    {
        $id_zone = null;
        $agentZone = Agent::latest()->first();

        $listeAgent = DB::table('agents')
            ->when($agentZone && $agentZone->rattachement_type_id === 1, function($query) {
                return $query->join('directions', 'agents.rattachement_zone_id', '=', 'directions.id');
            }, function($query) {
                return $query->join('agents as rattachement', 'agents.rattachement_zone_id', '=', 'rattachement.id');
            })
            ->join('users', 'agents.id_user_create', '=', 'users.id')
            ->select('agents.*', 'users.name', 'users.email')
            ->addSelect($agentZone && $agentZone->rattachement_type_id === 1 
                ? 'directions.libelle' 
                : 'rattachement.libelle')
            ->orderBy('agents.created_at', 'desc')
            ->limit(1)
            ->get();

        return view('pages.back-office-agent.index', compact('listeAgent', 'id_zone'));
    }

    public function mesDirectionsAdmin()
    {
        $directions = Direction::all();
        $id_zone = '1';

        $listeAgent = DB::table('agents')
            ->where('rattachement_type_id', 1)
            ->whereNull('deleted_at')
            ->join('directions', 'agents.rattachement_zone_id', '=', 'directions.id')
            ->join('users', 'agents.id_user_create', '=', 'users.id')
            ->orderBy('agents.nom', 'asc')
            ->select('agents.*', 'directions.libelle', 'users.name', 'users.email')
            ->get();

        return view('pages.back-office-agent.index', compact('listeAgent', 'id_zone', 'directions'));
    }

    public function mesServicesAdmin()
    {
        $agents = Agent::count();
        $id_zone = '2';

        $listeAgent = DB::table('agents')
            ->where('rattachement_type_id', 2)
            ->whereNull('deleted_at')
            ->join('agents as rattachement', 'agents.rattachement_zone_id', '=', 'rattachement.id')
            ->join('users', 'agents.id_user_create', '=', 'users.id')
            ->orderBy('agents.created_at', 'desc')
            ->select('agents.*', 'rattachement.libelle', 'users.name', 'users.email')
            ->get();

        return view('pages.back-office-agent.index', compact('listeAgent', 'id_zone', 'agents'));
    }

    public function directions()
    {
        $directions = Direction::all();
        $id_zone = '1';

        $listeAgent = DB::table('agents')
            ->where('rattachement_type_id', 1)
            ->whereNull('deleted_at')
            ->join('directions', 'agents.rattachement_zone_id', '=', 'directions.id')
            ->join('users', 'agents.id_user_create', '=', 'users.id')
            ->orderBy('agents.nom', 'asc')
            ->select('agents.*', 'directions.libelle', 'users.name', 'users.email')
            ->get();

        return view('pages.back-office-agent.index', compact('listeAgent', 'id_zone', 'directions'));
    }

    public function services()
    {
        $agents = Agent::all();
        $id_zone = '2';

        $listeAgent = DB::table('agents')
            ->where('rattachement_type_id', 2)
            ->whereNull('deleted_at')
            ->join('agents as rattachement', 'agents.rattachement_zone_id', '=', 'rattachement.id')
            ->join('users', 'agents.id_user_create', '=', 'users.id')
            ->orderBy('agents.created_at', 'desc')
            ->select('agents.*', 'rattachement.libelle', 'users.name', 'users.email')
            ->get();

        return view('pages.back-office-agent.index', compact('listeAgent', 'id_zone', 'agents'));
    }

    public function ListeProvincesAjax($id)
    {
        $provincesAll = Cache::remember('provincesAll', 86400, fn() => Province::all());
        $provinces = $provincesAll->where("region_id", $id);
        return response()->json($provinces);
    }

    public function ListeServicesAjax($id)
    {
        $agentsAll = Cache::remember('agentsAll', 86400, fn() => Agent::all());
        $services = $agentsAll->where("province_id", $id);
        return response()->json($services);
    }

    public function etatServiceAjax($id)
    {
        $services = Agent::where('rattachement_type_id', 2)
                       ->where('rattachement_zone_id', $id)
                       ->whereNull('deleted_at')
                       ->count();

        return response()->json($services);
    }
}