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

use App\Exports\AgentsExport;  // Doit pointer vers le bon namespace
use App\Exports\CsvExport;

class PageController extends Controller
{


public function getDirectionsWithServices()
    {
        return Cache::remember('directions_services', 3600, function() {
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
          $totalDirection = Agent::count(); // Exemple : total des agents
        $directions = Direction::withCount('agents')->get();
        $services = Service::withCount('agents')->get();
        
        return view('pages.front-end.accueil', compact('totalDirection','directions', 'services'));
    }

public function accueil()
{
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
        return $this->getAgentsByRattachement(2, 'rattachement.libelle');
    }

    protected function getAgentsByRattachement($typeId, $libelleField)
    {
        $query = Agent::with(['userCreate'])
            ->where('rattachement_type_id', $typeId)
            ->whereNull('deleted_at');

        if ($typeId === 1) {
            $query->join('directions', 'agents.rattachement_zone_id', '=', 'directions.id')
                  ->addSelect('directions.libelle');
        } else {
            $query->join('agents as rattachement', 'agents.rattachement_zone_id', '=', 'rattachement.id')
                  ->addSelect('rattachement.libelle');
        }

        $listeAgent = $query->join('users', 'agents.id_user_create', '=', 'users.id')
                          ->orderBy('agents.nom', 'asc')
                          ->select('agents.*', 'users.name', 'users.email')
                          ->get();

        $id_zone = (string)$typeId;
        $directions = $typeId === 1 ? Direction::all() : null;

        return view('pages.back-office-agent.index', compact('listeAgent', 'id_zone', 'directions'));
    }

    public function ListeProvincesAjax($id)
    {
        return Cache::remember("provinces_region_{$id}", 86400, function() use ($id) {
            return Province::where("region_id", $id)->get();
        });
    }

    public function ListeServicesAjax($id)
    {
        return Cache::remember("services_province_{$id}", 86400, function() use ($id) {
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


 public function exportAgents(Request $request)
    {
        $query = $this->buildExportQuery($request);
        $agents = $query->get();
        
        if ($request->format === 'excel') {
            $filename = $this->generateExportFilename($request);
            return $this->exportToExcel($agents, $filename);
        }
        
        return response()->json($agents); // Fallback pour d'autres formats
    }

    protected function buildExportQuery(Request $request)
    {
        return Agent::with(['service', 'direction'])
            ->when($request->export_type === 'direction', function ($q) use ($request) {
                $q->where('direction_id', $request->direction_id);
            })
            ->when($request->export_type === 'service', function ($q) use ($request) {
                $q->where('service_id', $request->service_id);
            })
            ->when($request->export_type === 'statut', function ($q) use ($request) {
                $q->where('statut', $request->statut);
            });
    }

    public function getServices($directionId)
    {
        return Service::where('direction_id', $directionId)->get(['id', 'name']);
    }

    public function exportByDirection($directionId)
    {
        $direction = Direction::findOrFail($directionId);
        $agents = Agent::with(['service', 'direction'])
                    ->where('direction_id', $directionId)
                    ->get();

        $filename = $this->generateFilename('Direction', $direction->name);
        return $this->exportToExcel($agents, $filename);
    }

 

    public function exportAll(Request $request)
    {
        $agents = Agent::with(['service', 'direction'])
                    ->when($request->filled('statut'), fn($q) => $q->where('statut', $request->statut))
                    ->when($request->filled('direction_id'), fn($q) => $q->where('direction_id', $request->direction_id))
                    ->when($request->filled('service_id'), fn($q) => $q->where('service_id', $request->service_id))
                    ->get();

        $filename = $this->generateFilename('Complet');
        return $this->exportToExcel($agents, $filename);
    }

    protected function exportToExcel($data, $filename)
    {
        return Excel::download(new AgentsExport($data), $filename);
    }

    protected function generateExportFilename(Request $request)
    {
        $type = $request->export_type;
        $params = [
            'direction' => Direction::find($request->direction_id),
            'service' => Service::find($request->service_id),
            'statut' => $request->statut
        ];

        return $this->generateFilename(
            ucfirst($type),
            $type === 'direction' ? $params['direction']->name : 
            ($type === 'service' ? $params['service']->name : $params['statut'])
        );
    }

    protected function generateFilename($type, $name = null)
    {
        $base = "Export_Agents_{$type}";
        $namePart = $name ? '_'.str_replace(' ', '_', $name) : '';
        $date = now()->format('Y-m-d_H-i-s');
        
        return "{$base}{$namePart}_{$date}.xlsx";
    }

    public function exportFiltered(Request $request)
{
    // Logique de filtrage spécifique
    return Excel::download(...);
}
public function exportByService($serviceId)
{
    try {
        // Vérifiez s'il y a des agents dans ce service
        $hasAgents = Agent::where('service_id', $serviceId)->exists();
        
        if (!$hasAgents) {
            return back()->with('error', 'Aucun agent dans ce service');
        }

        // Retournez l'export Excel
        return Excel::download(
            new CsvExport(3, $serviceId), 
            'agents_par_service_'.$serviceId.'.xlsx'
        );
    } catch (\Exception $e) {
        return back()->with('error', 'Erreur lors de l\'export: '.$e->getMessage());
    }
}

}
