<?php

namespace App\Http\Controllers;

use App\Exports\AgentsExport;
use App\Models\Agent;
use App\Models\Direction;
use App\Models\Service;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportService($id)
    {
        // Logique pour exporter les données d’un service
        return response()->json([
            'message' => "Export du service ID $id"
        ]);
    }
    public function exportDirection() // ou exportByDirection
    {
        $agents = Agent::with(['direction', 'service'])->get();
        return Excel::download(new AgentsExport($agents), 'directions.xlsx');
    }
 

public function exportAgents(Request $request)
    {
        $query = Agent::query()
            ->with(['direction', 'service', 'statut']);

        // Filtrage par type
        switch ($request->type) {
            case 'direction':
                $query->whereHas('direction', function($q) use ($request) {
                    $q->where('id', $request->direction_id);
                });
                break;

            case 'service':
                $query->whereHas('service', function($q) use ($request) {
                    $q->where('id', $request->service_id);
                });
                break;

            case 'statut':
                $query->where('statut', $request->statut);
                break;
        }

        return Excel::download(new AgentsExport($query), 'agents.' . $request->format);
    }

    public function exportByDirection(Direction $direction)
{
    $agents = Agent::where('direction_id', $direction->id)->get();
    return Excel::download(new AgentsExport($agents), "direction-{$direction->slug}.xlsx");
}

public function exportByService(Service $service)
{
    $agents = Agent::where('service_id', $service->id)->get();
    return Excel::download(new AgentsExport($agents), "service-{$service->slug}.xlsx");
}

public function exportFiltered(Request $request)
{
    $query = Agent::query();
    
    if($request->has('statut')) {
        $query->where('statut', $request->statut);
    }
    
    return Excel::download(new AgentsExport($query->get()), "agents-filtres.xlsx");
}


public function exportAll()
{
    $agents = Agent::with(['direction', 'service'])->get();
    
    $filename = 'Tous_les_agents_'.now()->format('Y-m-d').'.xlsx';
    return Excel::download(new AgentsExport($agents), $filename);
}


    // ... (conservez vos autres méthodes existantes)

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
