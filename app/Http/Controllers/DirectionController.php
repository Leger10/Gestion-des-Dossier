<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectionController extends Controller
{
   public function index()
{
    $stats = [];
$directions = Direction::with(['services' => function($query) {
    $query->withCount('agents');
}])->withCount('services')->get();

    // Totaux généraux
    $stats['totalAgents'] = Agent::count();
    $stats['totalDirection'] = Agent::distinct('direction_id')->count('direction_id');
    $stats['totalService'] = Agent::distinct('service_id')->count('service_id');

    // Par genre
    $stats['hommesTotal'] = Agent::where('sexe', 'M')->count();
    $stats['femmesTotal'] = Agent::where('sexe', 'F')->count();

    // Par direction
    $stats['hommesDirection'] = Agent::where('sexe', 'M')->whereNotNull('direction_id')->count();
    $stats['femmesDirection'] = Agent::where('sexe', 'F')->whereNotNull('direction_id')->count();
    $stats['totalDirection'] = Agent::whereNotNull('direction_id')->count();

    // Par service
    $stats['hommesService'] = Agent::where('sexe', 'M')->whereNotNull('service_id')->count();
    $stats['femmesService'] = Agent::where('sexe', 'F')->whereNotNull('service_id')->count();
    $stats['totalService'] = Agent::whereNotNull('service_id')->count();

    // Répartition par catégorie (Direction)
    $categories = ['I', 'II', 'III', 'Néant'];
    foreach ($categories as $cat) {
        $stats['directionCategories'][$cat] = [
            'hommes' => Agent::where('categorie', $cat)->where('sexe', 'M')->whereNotNull('direction_id')->count(),
            'femmes' => Agent::where('categorie', $cat)->where('sexe', 'F')->whereNotNull('direction_id')->count(),
        ];
        $stats['directionCategories'][$cat]['total'] = $stats['directionCategories'][$cat]['hommes'] + $stats['directionCategories'][$cat]['femmes'];
    }

    // Répartition par catégorie (Service)
    foreach ($categories as $cat) {
        $stats['serviceCategories'][$cat] = [
            'hommes' => Agent::where('categorie', $cat)->where('sexe', 'M')->whereNotNull('service_id')->count(),
            'femmes' => Agent::where('categorie', $cat)->where('sexe', 'F')->whereNotNull('service_id')->count(),
        ];
        $stats['serviceCategories'][$cat]['total'] = $stats['serviceCategories'][$cat]['hommes'] + $stats['serviceCategories'][$cat]['femmes'];
    }

    // Récapitulatif par directions
    $directionNames = Direction::pluck('name')->toArray();
    $stats['directionNames'] = $directionNames;
    foreach ($directionNames as $name) {
        $direction = Direction::where('name', $name)->first();
        if ($direction) {
            $stats['directionRecap'][$name] = [
                'hommes' => Agent::where('sexe', 'M')->where('direction_id', $direction->id)->count(),
                'femmes' => Agent::where('sexe', 'F')->where('direction_id', $direction->id)->count(),
            ];
            $stats['directionRecap'][$name]['total'] =
                $stats['directionRecap'][$name]['hommes'] + $stats['directionRecap'][$name]['femmes'];
        }
    }
     // Récupère toutes les directions avec leurs services et le nombre d'agents par service
        $directions = Direction::with(['services' => function($query) {
            $query->withCount('agents');
        }])->withCount('services')->get();

        // Calcul des totaux
        $totalDirections = Direction::count();
        $totalServices = Service::count();
        $totalAgents = Agent::count();

        // Récupération des agents par direction
        $agentsParDirection = Direction::withCount(['agents' => function($query) {
            $query->select(DB::raw('count(distinct agents.id)'));
        }])->get()->pluck('agents_count', 'name');

        // Récupération des agents par service
        $agentsParService = Service::withCount('agents')->get()
            ->mapWithKeys(function ($service) {
                return [$service->name => $service->agents_count];
            });

        return view('directions.index', compact(
            'directions',
            'totalDirections',
            'totalServices',
            'totalAgents',
            'agentsParDirection',
            'agentsParService',
            'stats',
        ));
    }

  
    public function create()
    {
        // La création est gérée via modal, rediriger vers l'index
        return redirect()->route('directions.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:directions,name',
            'description' => 'nullable|string'
        ]);

        Direction::create($validated);

        return redirect()->route('directions.index')
            ->with('success', 'Direction créée avec succès.');
    }

    public function show($id)
    {
        $direction = Direction::with('services')->findOrFail($id);
        return view('admin.structure.show', compact('direction'));
    }

    public function edit($id)
    {
        $direction = Direction::findOrFail($id);
        return response()->json($direction);
    }

    public function update(Request $request, $id)
    {
        $direction = Direction::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:directions,name,'.$direction->id,
            
        ]);

        $direction->update($validated);

        return redirect()->route('directions.index')
            ->with('success', 'Direction mise à jour avec succès');
    }

    public function destroy($id)
    {
        $direction = Direction::findOrFail($id);
        
        // Vérifier s'il y a des services associés
        if ($direction->services()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer : des services y sont associés.');
        }

        $direction->delete();

        return redirect()->route('directions.index')
            ->with('success', 'Direction supprimée avec succès');
    }

    public function getServices(Direction $direction)
{
    return response()->json($direction->services()->orderBy('name')->get());
}

    public function getAgentsByDirection($id)
    {
        $agents = Agent::where('direction_id', $id)->get();
        return response()->json($agents);
    }
    public function getAgentsByService($id)
    {
        $agents = Agent::where('service_id', $id)->get();
        return response()->json($agents);
    }
    public function getAgentsByDirectionAndService($directionId, $serviceId)
    {
        $agents = Agent::where('direction_id', $directionId)
            ->where('service_id', $serviceId)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByDirectionAndServiceAndType($directionId, $serviceId, $typeId)
    {
        $agents = Agent::where('direction_id', $directionId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByServiceAndType($serviceId, $typeId)
    {
        $agents = Agent::where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByType($typeId)
    {
        $agents = Agent::where('rattachement_type_id', $typeId)->get();
        return response()->json($agents);
    }
    public function getAgentsByTypeAndZone($typeId, $zoneId)
    {
        $agents = Agent::where('rattachement_type_id', $typeId)
            ->where('rattachement_zone_id', $zoneId)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZone($zoneId)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndType($zoneId, $typeId)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('rattachement_type_id', $typeId)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndService($zoneId, $serviceId)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndType($zoneId, $serviceId, $typeId)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirection($zoneId, $serviceId, $typeId, $directionId)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatus($zoneId, $serviceId, $typeId, $directionId, $status)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', $status)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexe($zoneId, $serviceId, $typeId, $directionId, $status, $sexe)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', $status)
            ->where('sexe', $sexe)
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatricule($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', $status)
            ->where('sexe', $sexe)
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndName($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', $status)
            ->where('sexe', $sexe)
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenom($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', $status)
            ->where('sexe', $sexe)
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaiss($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', $status)
            ->where('sexe', $sexe)
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->whereDate('date_naiss', '=', date($dateNaiss))
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeService($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', $status)
            ->where('sexe', $sexe)
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->whereDate('date_naiss', '=', date($dateNaiss))
            ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploi($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', $status)
            ->where('sexe', $sexe)
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->whereDate('date_naiss', '=', date($dateNaiss))
            ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
            ->where('emploi', 'like', '%' . $emploi . '%')
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonction($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', $status)
            ->where('sexe', $sexe)
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->whereDate('date_naiss', '=', date($dateNaiss))
            ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
            ->where('emploi', 'like', '%' . $emploi . '%')
            ->where('fonction', 'like', '%' . $fonction . '%')
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatut($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', 'like', '%' . $status . '%')
            ->where('sexe', 'like', '%' . $sexe . '%')
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->whereDate('date_naiss', '=', date($dateNaiss))
            ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
            ->where('emploi', 'like', '%' . $emploi . '%')
            ->where('fonction', 'like', '%' . $fonction . '%')
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatutAndCategorie($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction, $categorie)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', 'like', '%' . $status . '%')
            ->where('sexe', 'like', '%' . $sexe . '%')
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->whereDate('date_naiss', '=', date($dateNaiss))
            ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
            ->where('emploi', 'like', '%' . $emploi . '%')
            ->where('fonction', 'like', '%' . $fonction . '%')
            ->where('categorie', 'like', '%' . $categorie . '%')
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatutAndCategorieAndGrade($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction, $categorie, $grade)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', 'like', '%' . $status . '%')
            ->where('sexe', 'like', '%' . $sexe . '%')
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->whereDate('date_naiss', '=', date($dateNaiss))
            ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
            ->where('emploi', 'like', '%' . $emploi . '%')
            ->where('fonction', 'like', '%' . $fonction . '%')
            ->where('categorie', 'like', '%' . $categorie . '%')
            ->where('grade', 'like', '%' . $grade . '%')
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatutAndCategorieAndGradeAndClasse($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction, $categorie, $grade, $classe)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', 'like', '%' . $status . '%')
            ->where('sexe', 'like', '%' . $sexe . '%')
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->whereDate('date_naiss', '=', date($dateNaiss))
            ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
            ->where('emploi', 'like', '%' . $emploi . '%')
            ->where('fonction', 'like', '%' . $fonction . '%')
            ->where('categorie', 'like', '%' . $categorie . '%')
            ->where('grade', 'like', '%' . $grade . '%')
            ->where('classe', 'like', '%' . $classe . '%')
            ->get();
        return response()->json($agents);
    }
    public function getAgentsByZoneAndServiceAndTypeAndDirectionAndStatusAndSexeAndMatriculeAndNameAndPrenomAndDateNaissAndDatePriseDeServiceAndEmploiAndFonctionAndStatutAndCategorieAndGradeAndClasseAndEchelon($zoneId, $serviceId, $typeId, $directionId, $status, $sexe, $matricule, $name, $prenom, $dateNaiss, $datePriseDeService, $emploi, $fonction, $categorie, $grade, $classe, $echelon)
    {
        $agents = Agent::where('rattachement_zone_id', $zoneId)
            ->where('service_id', $serviceId)
            ->where('rattachement_type_id', $typeId)
            ->where('direction_id', $directionId)
            ->where('statut', 'like', '%' . $status . '%')
            ->where('sexe', 'like', '%' . $sexe . '%')
            ->where('matricule', 'like', '%' . $matricule . '%')
            ->where('nom', 'like', '%' . $name . '%')
            ->where('prenom', 'like', '%' . $prenom . '%')
            ->whereDate('date_naiss', '=', date($dateNaiss))
            ->whereDate('date_prise_de_service', '=', date($datePriseDeService))
            ->where('emploi', 'like', '%' . $emploi . '%')
            ->where('fonction', 'like', '%' . $fonction . '%')
            ->where('categorie', 'like', '%' . $categorie . '%')
            ->where('grade', 'like', '%' . $grade . '%')
            ->where('classe', 'like', '%' . $classe . '%')
            ->where('echelon', 'like', '%' . $echelon . '%')
            ->get();
        return response()->json($agents);
    }
}