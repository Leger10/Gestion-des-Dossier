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
        return $this->getAgentsByRattachement(2, 'services.libelle');
    }

    protected function getAgentsByRattachement($typeId, $libelleField)
    {
        $query = Agent::with(['userCreate', 'service'])
            ->where('rattachement_type_id', $typeId)
            ->whereNull('deleted_at');

        if ($typeId === 1) {
            $query->join('directions', 'agents.rattachement_zone_id', '=', 'directions.id')
                  ->addSelect('directions.libelle as direction_libelle');
        } else {
            $query->join('services', 'agents.rattachement_zone_id', '=', 'services.id')
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

//  // ExportController.php
// public function exportByDirection($direction)
// {
//     $agents = Agent::where('direction_id', $direction)->get();
//     return Excel::download(new AgentsExport($agents), 'agents_direction.xlsx');
// }

// public function exportByService($service)
// {
//     $agents = Agent::where('service_id', $service)->get();
//     return Excel::download(new AgentsExport($agents), 'agents_service.xlsx');
// }



// public function exportAll()
// {
//     $agents = Agent::with(['direction', 'service'])->get();
    
//     $filename = 'Tous_les_agents_'.now()->format('Y-m-d').'.xlsx';
//     return Excel::download(new AgentsExport($agents), $filename);
// }

// public function exportFiltered(Request $request)
// {
//     $query = Agent::with(['direction', 'service']);

//     if ($request->type === 'direction' && $request->direction_id) {
//         $query->where('direction_id', $request->direction_id);
//     }

//     if ($request->type === 'service' && $request->service_id) {
//         $query->where('service_id', $request->service_id);
//     }

//     if ($request->type === 'statut' && $request->statut) {
//         $query->where('statut', $request->statut);
//     }

//     $agents = $query->get();

//     if ($agents->isEmpty()) {
//         return back()->with('error', 'Aucun agent trouvé avec ces critères');
//     }

//     $filename = 'Agents_Filtres_'.now()->format('Y-m-d').'.xlsx';
//     return Excel::download(new AgentsExport($agents), $filename);
// }

//     // ... (conservez vos autres méthodes existantes)

//     public function getServices(Direction $direction)
// {
//     return response()->json($direction->services()->orderBy('name')->get());
// }

//     public function getAgentsByDirection($id)
//     {
//         $agents = Agent::where('direction_id', $id)->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByService($id)
//     {
//         $agents = Agent::where('service_id', $id)->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByDirectionAndService($directionId, $serviceId)
//     {
//         $agents = Agent::where('direction_id', $directionId)
//             ->where('service_id', $serviceId)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByDirectionAndServiceAndType($directionId, $serviceId, $typeId)
//     {
//         $agents = Agent::where('direction_id', $directionId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByServiceAndType($serviceId, $typeId)
//     {
//         $agents = Agent::where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByType($typeId)
//     {
//         $agents = Agent::where('rattachement_type_id', $typeId)->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByTypeAndZone($typeId, $zoneId)
//     {
//         $agents = Agent::where('rattachement_type_id', $typeId)
//             ->where('rattachement_zone_id', $zoneId)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZone($zoneId)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndType($zoneId, $typeId)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('rattachement_type_id', $typeId)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndService($zoneId, $serviceId)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndType($zoneId, $serviceId, $typeId)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirection($zoneId, $serviceId, $typeId, $directionId)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatus($zoneId, $serviceId, $typeId, $directionId, $status)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', $status)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexe($zoneId, $serviceId, $typeId, $directionId, $status, $sexe)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', $status)
//             ->where('sexe', $sexe)
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatricule($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', $status)
//             ->where('sexe', $sexe)
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndName($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', $status)
//             ->where('sexe', $sexe)
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenom($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', $status)
//             ->where('sexe', $sexe)
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaiss($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', $status)
//             ->where('sexe', $sexe)
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->whereDate('date_naiss', '=', date($dateNaiss))
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeService($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', $status)
//             ->where('sexe', $sexe)
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->whereDate('date_naiss', '=', date($dateNaiss))
//             ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploi($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', $status)
//             ->where('sexe', $sexe)
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->whereDate('date_naiss', '=', date($dateNaiss))
//             ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
//             ->where('emploi', 'like', '%' . $emploi . '%')
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonction($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', $status)
//             ->where('sexe', $sexe)
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->whereDate('date_naiss', '=', date($dateNaiss))
//             ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
//             ->where('emploi', 'like', '%' . $emploi . '%')
//             ->where('fonction', 'like', '%' . $fonction . '%')
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatut($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', 'like', '%' . $status . '%')
//             ->where('sexe', 'like', '%' . $sexe . '%')
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->whereDate('date_naiss', '=', date($dateNaiss))
//             ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
//             ->where('emploi', 'like', '%' . $emploi . '%')
//             ->where('fonction', 'like', '%' . $fonction . '%')
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatutAndCategorie($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction, $categorie)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', 'like', '%' . $status . '%')
//             ->where('sexe', 'like', '%' . $sexe . '%')
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->whereDate('date_naiss', '=', date($dateNaiss))
//             ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
//             ->where('emploi', 'like', '%' . $emploi . '%')
//             ->where('fonction', 'like', '%' . $fonction . '%')
//             ->where('categorie', 'like', '%' . $categorie . '%')
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatutAndCategorieAndGrade($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction, $categorie, $grade)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', 'like', '%' . $status . '%')
//             ->where('sexe', 'like', '%' . $sexe . '%')
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->whereDate('date_naiss', '=', date($dateNaiss))
//             ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
//             ->where('emploi', 'like', '%' . $emploi . '%')
//             ->where('fonction', 'like', '%' . $fonction . '%')
//             ->where('categorie', 'like', '%' . $categorie . '%')
//             ->where('grade', 'like', '%' . $grade . '%')
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatutAndCategorieAndGradeAndClasse($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction, $categorie, $grade, $classe)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', 'like', '%' . $status . '%')
//             ->where('sexe', 'like', '%' . $sexe . '%')
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->whereDate('date_naiss', '=', date($dateNaiss))
//             ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
//             ->where('emploi', 'like', '%' . $emploi . '%')
//             ->where('fonction', 'like', '%' . $fonction . '%')
//             ->where('categorie', 'like', '%' . $categorie . '%')
//             ->where('grade', 'like', '%' . $grade . '%')
//             ->where('classe', 'like', '%' . $classe . '%')
//             ->get();
//         return response()->json($agents);
//     }
//     public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatutAndCategorieAndGradeAndClasseAndEchelon($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction, $categorie, $grade, $classe, $echelon)
//     {
//         $agents = Agent::where('rattachement_zone_id', $zoneId)
//             ->where('service_id', $serviceId)
//             ->where('rattachement_type_id', $typeId)
//             ->where('direction_id', $directionId)
//             ->where('statut', 'like', '%' . $status . '%')
//             ->where('sexe', 'like', '%' . $sexe . '%')
//             ->where('matricule', 'like', '%' . $matricule . '%')
//             ->where('nom', 'like', '%' . $name . '%')
//             ->where('prenom', 'like', '%' . $prenom . '%')
//             ->whereDate('date_naiss', '=', date($dateNaiss))
//             ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
//             ->where('emploi', 'like', '%' . $emploi . '%')
//             ->where('fonction', 'like', '%' . $fonction . '%')
//             ->where('categorie', 'like', '%' . $categorie . '%')
//             ->where('grade', 'like', '%' . $grade . '%')
//             ->where('classe', 'like', '%' . $classe . '%')
//             ->where('echelon', 'like', '%' . $echelon . '%')
//             ->get();
//         return response()->json($agents);
//     }


    
// public function exportAgents(Request $request)
//     {
//         $query = Agent::query()
//             ->with(['direction', 'service', 'statut']);

//         // Filtrage par type
//         switch ($request->type) {
//             case 'direction':
//                 $query->whereHas('direction', function($q) use ($request) {
//                     $q->where('id', $request->direction_id);
//                 });
//                 break;

//             case 'service':
//                 $query->whereHas('service', function($q) use ($request) {
//                     $q->where('id', $request->service_id);
//                 });
//                 break;

//             case 'statut':
//                 $query->where('statut', $request->statut);
//                 break;
//         }

//         return Excel::download(new AgentsExport($query), 'agents.' . $request->format);
//     }
}

