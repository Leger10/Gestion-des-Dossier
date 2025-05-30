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
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

use App\Exports\AgentsExport;  // Doit pointer vers le bon namespace
use App\Exports\CsvExport;

class PageController extends Controller
{


    public function getData()
    {
        try {
            // Récupérer tous les agents non supprimés
            $agents = Agent::with(['direction', 'service'])
                ->whereNull('deleted_at')
                ->get();

            // Calculer les statistiques pour les directions
            $directionsData = [
                'total' => $agents->where('direction_id', '!=', null)->count(),
                'hommes' => $agents->where('direction_id', '!=', null)->where('sexe', 'Masculin')->count(),
                'femmes' => $agents->where('direction_id', '!=', null)->where('sexe', 'Feminin')->count(),
                'categories' => [
                    'homme' => $this->getCategoryCounts($agents->where('direction_id', '!=', null), 'Masculin'),
                    'femme' => $this->getCategoryCounts($agents->where('direction_id', '!=', null), 'Feminin')
                ]
            ];

            // Calculer les statistiques pour les services
            $servicesData = [
                'total' => $agents->where('service_id', '!=', null)->count(),
                'hommes' => $agents->where('service_id', '!=', null)->where('sexe', 'Masculin')->count(),
                'femmes' => $agents->where('service_id', '!=', null)->where('sexe', 'Feminin')->count(),
                'categories' => [
                    'homme' => $this->getCategoryCounts($agents->where('service_id', '!=', null), 'Masculin'),
                    'femme' => $this->getCategoryCounts($agents->where('service_id', '!=', null), 'Feminin')
                ]
            ];

            // Répartition par direction avec des requêtes optimisées
            $repartition = [];
            $directions = Direction::all();
            
            foreach ($directions as $direction) {
                $hommes = Agent::where('direction_id', $direction->id)
                            ->where('sexe', 'Masculin')
                            ->count();
                
                $femmes = Agent::where('direction_id', $direction->id)
                            ->where('sexe', 'Feminin')
                            ->count();
                
                $repartition[] = [
                    'nom' => $direction->name,
                    'hommes' => $hommes,
                    'femmes' => $femmes
                ];
            }

            return response()->json([
                'success' => true,
                'directions' => $directionsData,
                'services' => $servicesData,
                'repartition' => $repartition
            ]);

        } catch (\Exception $e) {
            Log::error("Erreur dans getData: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'Une erreur est survenue lors du chargement des données',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    
    private function getCategoryCounts($agents, $sexe)
    {
        $filtered = $agents->where('sexe', $sexe);
        
        return [
            'I' => $filtered->where('categorie', 'I')->count(),
            'II' => $filtered->where('categorie', 'II')->count(),
            'III' => $filtered->where('categorie', 'III')->count(),
            'Néant' => $filtered->where('categorie', 'Néant')->count()
        ];
    }
   
    
   

    public function getDirectionsWithServices()
    {
        return Cache::remember('directions_services', 3600, function () {
            $directions = Direction::with('services')->get();
            $result = [];

            foreach ($directions as $direction) {
                $result[$direction->code] = $direction->services->pluck('name')->toArray();
            }

            return $result;
        });
    }

    public function index()
{
    $totalDirection = Agent::count(); // total des agents

    // Directions et services avec compte agents
    $directions = Direction::withCount(['agents', 'services'])
        ->with(['services' => function($query) {
            $query->withCount('agents');
        }])
        ->orderBy('name')
        ->get();

    $services = Service::withCount('agents')->get();

    $direction = Agent::all();
$service = Agent::all(); // ou ta logique spécifique

$directionHommes = $direction->where('sexe', 'Masculin');
$directionFemmes = $direction->where('sexe', 'Feminin');

$serviceHommes = $service->where('sexe', 'Masculin');
$serviceFemmes = $service->where('sexe', 'Feminin');

    // Compte agents par catégorie (en supposant colonne 'categorie')
    $categoriesCount = Agent::select('categorie')
        ->selectRaw('count(*) as total')
        ->groupBy('categorie')
        ->get();

    // Si tu as besoin d'envoyer tout ça à la vue
    return view('pages.front-end.accueil', compact(
        'totalDirection', 
        'directions', 
        'services',
        'hommesCount',
        'femmesCount',
        'categoriesCount'
    ));
}


    public function accueil()
    {


        $agents = Agent::whereNull('deleted_at')->paginate(24);


        // Comptage des agents archivés (une seule déclaration)
        $archivedCount = Agent::where('is_archived', true)->count();

        // Si besoin du nombre total d'agents actifs (alternative)
        $totalActive = Agent::where('is_archived', false)->count();
        // Tous les agents non supprimés
        $agents = Agent::with(['direction', 'service'])
            ->whereNull('deleted_at')
            ->paginate(24);

        // Statistiques globales
        $stats = [
            'total' => $agents->total(),
            'hommes' => $agents->where('sexe', 'Masculin')->count(),
            'femmes' => $agents->where('sexe', 'Feminin')->count(),
        ];

        // Tous les agents (non paginés) pour les stats détaillées
        $allAgents = Agent::with(['direction', 'service'])->whereNull('deleted_at')->get();

        // Agents par Direction
        $directionAgents = $allAgents->filter(function ($agent) {
            return $agent->direction !== null;
        });

        // Agents par Service
        $serviceAgents = $allAgents->filter(function ($agent) {
            return $agent->service !== null;
        });

        // Statistiques DGTI
        $directionHommes = $directionAgents->where('sexe', 'Masculin')->count();
        $directionFemmes = $directionAgents->where('sexe', 'Feminin')->count();
        $totalDirection = $directionAgents->count();

        // Statistiques par Service
        $serviceHommes = $serviceAgents->where('sexe', 'Masculin')->count();
        $serviceFemmes = $serviceAgents->where('sexe', 'Feminin')->count();
        $totalService = $serviceAgents->count();

        return view('pages.back-office-agent.accueil', [
            'agents' => $agents,
            'stats' => $stats,
            'totalDirection' => $totalDirection,
            'directionHommes' => $directionHommes,
            'directionFemmes' => $directionFemmes,
            'totalService' => $totalService,
            'serviceHommes' => $serviceHommes,
            'serviceFemmes' => $serviceFemmes,
            'directionAgents' => $directionAgents,
            'serviceAgents' => $serviceAgents,
        ]);
    }

    protected function getEntityStats($rattachementType)
    {
        return Agent::select(
            DB::raw('count(*) as total'),
            DB::raw('sum(case when sexe = "Masculin" then 1 else 0 end) as hommes'),
            DB::raw('sum(case when sexe = "Feminin" then 1 else 0 end) as femmes')
        )
            ->where('rattachement_type_id', $rattachementType)
            ->whereNull('deleted_at')
            ->groupBy('rattachement_zone_id')
            ->get();
    }

    public function agentIndex()
    {
        $latestAgent = Agent::latest()->first();
        $id_zone = null;

        $query = Agent::with(['userCreate', 'rattachement'])
            ->select('agents.*')
            ->join('users', 'agents.id_user_create', '=', 'users.id');

        if ($latestAgent && $latestAgent->rattachement_type_id === 1) {
            $query->join('directions', 'agents.rattachement_zone_id', '=', 'directions.id')
                ->addSelect('directions.libelle');
        } else {
            $query->join('agents as rattachement', 'agents.rattachement_zone_id', '=', 'rattachement.id')
                ->addSelect('rattachement.libelle');
        }

        $listeAgent = $query->orderBy('agents.created_at', 'desc')
            ->limit(1)
            ->get();

            

        return view('pages.back-office-agent.index', compact('listeAgent', 'id_zone'));
    }

    public function mesDirectionsAdmin()
    {
        return $this->getAgentsByRattachement(1, 'directions.libelle');
    }

    public function mesServicesAdmin()
    {
        return $this->getAgentsByRattachement(2, 'services.libelle');
    }

    protected function getAgentsByRattachement($typeId, $libelleField)
    {
        $query = Agent::with(['userCreate', 'service'])
            ->where('rattachement_type_id', $typeId)
            ->whereNull('deleted_at');

        if ($typeId === 1) {
            $query->join('directions', 'agents.direction_id', '=', 'directions.id')
                ->addSelect('directions.libelle as direction_libelle');
        } else {
            $query->join('services', 'agents.service_id', '=', 'services.id')
                ->addSelect('services.libelle as service_libelle');
        }

        $listeAgent = $query->join('users', 'agents.id_user_create', '=', 'users.id')
            ->orderBy('agents.nom', 'asc')
            ->select('agents.*', 'users.name', 'users.email')
            ->get();

        $id_zone = (string)$typeId;
        $directions = $typeId === 1 ? Direction::all() : null;
        $services = $typeId === 2 ? Service::all() : null;

        return view('pages.back-office-agent.index', compact('listeAgent', 'id_zone', 'services', 'directions'));
    }

    public function ListeProvincesAjax($id)
    {
        return Cache::remember("provinces_region_{$id}", 86400, function () use ($id) {
            return Province::where("region_id", $id)->get();
        });
    }

    public function ListeServicesAjax($id)
    {
        return Cache::remember("services_province_{$id}", 86400, function () use ($id) {
            return Agent::where("province_id", $id)->get();
        });
    }

    public function etatServiceAjax($id)
    {
        return Agent::where('rattachement_type_id', 2)
            ->where('rattachement_zone_id', $id)
            ->whereNull('deleted_at')
            ->count();
    }

      
  
}
