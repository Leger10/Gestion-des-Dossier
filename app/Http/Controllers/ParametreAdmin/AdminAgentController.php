<?php

namespace App\Http\Controllers\ParametreAdmin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
    use Carbon\Carbon;
class AdminAgentController extends Controller
{



public function index()
{
    $data = $this->getBaseData();

    // Nombre d'agents actifs (statut = 'actif')
    $activeCount = Agent::where('statut', 'actif')->whereNull('deleted_at')->count();
    $data['agents'] = Agent::with('direction', 'service')->paginate(10); // ou n'importe quel nombre par page

    $data['directions'] = Direction::all();
    $data['services'] = Service::all(); // ✅ Ajoute cette ligne
    $data['rattachementTypes'] = \App\Models\RattachementType::all();

    $data['activeCount'] = $activeCount;
    return view('pages.back-office-agent.dashboard', $data);
}

public function create()
{
    $directions = Direction::all();
    $services = Service::all();

    $servicesByDirection = $services->groupBy('direction_id')->map(function ($group) {
        return $group->map(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
            ];
        })->values();
    });

    $agent = new Agent(); // Objet vide pour la vue

    return view('pages.back-office-agent.create', compact('directions', 'servicesByDirection', 'agent'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|max:255',
        'prenom' => 'required|max:255',
        'telephone' => 'required',
        'date_naissance' => 'required|date',
        'lieu_naissance' => 'required',
        'sexe' => 'required|in:M,F',
        'situation_matrimoniale' => 'required',
        'matricule' => 'required|unique:agents,matricule',
        'nationalite' => 'required',
        'date_recrutement' => 'required|date',
        'diplome_recrutement' => 'required',
        'statut' => 'required',
        'position' => 'required',
        'grade' => 'required',
        'categorie' => 'required',
        'echelon' => 'required|integer|between:1,10',
        'indice' => 'nullable',
        'date_prise_de_service' => 'nullable|date',
        'rattachement_type' => 'required|in:direction,service',
        'rattachement_type_id' => 'required_if:rattachement_type,direction|exists:rattachement_types,id',
        'parent_direction_id' => 'required_if:rattachement_type,service|exists:directions,id',
        'service_id' => 'required_if:rattachement_type,service|exists:services,id',
    ]);

    // Créer un agent avec rattachement conditionnel
    Agent::create([
        // Remplissage des autres champs du validated, sauf rattachement
        'nom' => $validated['nom'],
        'prenom' => $validated['prenom'],
        'telephone' => $validated['telephone'],
        'date_naissance' => $validated['date_naissance'],
        'lieu_naissance' => $validated['lieu_naissance'],
        'sexe' => $validated['sexe'],
        'situation_matrimoniale' => $validated['situation_matrimoniale'],
        'matricule' => $validated['matricule'],
        'nationalite' => $validated['nationalite'],
        'date_recrutement' => $validated['date_recrutement'],
        'diplome_recrutement' => $validated['diplome_recrutement'],
        'statut' => $validated['statut'],
        'position' => $validated['position'],
        'grade' => $validated['grade'],
        'categorie' => $validated['categorie'],
        'echelon' => $validated['echelon'],
        'indice' => $validated['indice'] ?? null,
        'date_prise_de_service' => $validated['date_prise_de_service'] ?? null,

        // Rattachement selon le type choisi
        'direction_id' => $validated['rattachement_type'] === 'direction'
            ? $validated['rattachement_type_id']
            : $validated['parent_direction_id'],

        'service_id' => $validated['rattachement_type'] === 'service'
            ? $validated['service_id']
            : null,
    ]);

    return redirect()->route('admin.agents.dashboard')
        ->with('success', 'Agent créé avec succès');
}






public function update(Request $request, Agent $agent)
{
    $validated = $request->validate([
        // Validation similaire à store, mais unique matricule ignore l'actuel agent
        'nom' => 'required|max:255',
        'prenom' => 'required|max:255',
        'telephone' => 'required',
        'date_naissance' => 'required|date',
        'lieu_naissance' => 'required',
        'sexe' => 'required|in:M,F',
        'situation_matrimoniale' => 'required',
        'matricule' => 'required|unique:agents,matricule,' . $agent->id,
        'nationalite' => 'required',
        'date_recrutement' => 'required|date',
        'diplome_recrutement' => 'required',
        'statut' => 'required',
        'position' => 'required',
        'grade' => 'required',
        'categorie' => 'required',
        'echelon' => 'required|integer|between:1,10',
        'indice' => 'nullable',
        'date_prise_de_service' => 'nullable|date',
        'rattachement_type' => 'required|in:direction,service',
        'rattachement_type_id' => 'required_if:rattachement_type,direction|exists:rattachement_types,id',
        'parent_direction_id' => 'required_if:rattachement_type,service|exists:directions,id',
        'service_id' => 'required_if:rattachement_type,service|exists:services,id',
    ]);

    // Mise à jour avec rattachement conditionnel
    $agent->update([
        'nom' => $validated['nom'],
        'prenom' => $validated['prenom'],
        'telephone' => $validated['telephone'],
        'date_naissance' => $validated['date_naissance'],
        'lieu_naissance' => $validated['lieu_naissance'],
        'sexe' => $validated['sexe'],
        'situation_matrimoniale' => $validated['situation_matrimoniale'],
        'matricule' => $validated['matricule'],
        'nationalite' => $validated['nationalite'],
        'date_recrutement' => $validated['date_recrutement'],
        'diplome_recrutement' => $validated['diplome_recrutement'],
        'statut' => $validated['statut'],
        'position' => $validated['position'],
        'grade' => $validated['grade'],
        'categorie' => $validated['categorie'],
        'echelon' => $validated['echelon'],
        'indice' => $validated['indice'] ?? null,
        'date_prise_de_service' => $validated['date_prise_de_service'] ?? null,

        'direction_id' => $validated['rattachement_type'] === 'direction'
            ? $validated['rattachement_type_id']
            : $validated['parent_direction_id'],

        'service_id' => $validated['rattachement_type'] === 'service'
            ? $validated['service_id']
            : null,
    ]);

    return redirect()->route('admin.agents.dashboard')
        ->with('success', 'Agent modifié avec succès');
}

    public function edit(Agent $agent)
{
    // Récupérer toutes les directions avec leurs services
    $directions = \App\Models\Direction::with('services')->get();

    // Récupérer les types de rattachement (ex: direction, service)
    $rattachementTypes = \App\Models\RattachementType::all();

    // Déterminer le type de rattachement actuel (direction ou service)
    // Ici on suppose que si service_id est set, rattachement = service, sinon direction
    $rattachement_type = $agent->service_id ? 'service' : 'direction';

    return view('agents.edit', compact(
        'agent',
        'directions',
        'rattachementTypes',
        'rattachement_type'
    ));
}

    public function destroy(Agent $agent)
    {
        $detAgent = Agent::find($agent->id);
        if ($detAgent->is_archived) {
            return redirect()->back()->with('error', 'Cet agent est déjà archivé.');
        }
        $detAgent->delete(); // ou $agent->forceDelete();
        return redirect()->back()->with('success', 'Agent archivé avec succès.');
    }

    public function archive()
{
    // Récupérer les agents archivés (soft deleted) avec pagination
    $archivedAgents = Agent::onlyTrashed()->paginate(10);

   return view('partials.archived-list', array_merge($this->getBaseData(), [
    'archivedMode' => true,
    'detailAgent' => null,
    'archivedAgents' => $archivedAgents, // ici
]));
   }



public function restore($id)
{
    // Trouver l’agent soft deleted (archivé)
    $agent = Agent::onlyTrashed()->findOrFail($id);

    // Restaurer l’agent
    $agent->restore();

    // Rediriger vers la liste des agents archivés avec un message
    return redirect()->route('agent.archive')->with('success', 'Agent restauré avec succès.');
}


    private function getBaseData()
    {
        return [
            'agents' => Agent::with(['direction', 'service'])
                ->where('is_archived', false)
                ->orderBy('nom')
                ->paginate(10),
            'archivedCount' => Agent::where('is_archived', true)->count(),
            'totalActive' => Agent::where('is_archived', false)->count()
        ];
    }


    // protected function messages()
    // {
    //     return [
    //         // Informations personnelles
    //         'nom.required' => 'Le nom est requis.',
    //         'prenom.required' => 'Le prénom est requis.',
    //         'sexe.required' => 'Le sexe est requis.',
    //         'sexe.in' => 'Le sexe doit être soit Masculin, soit Féminin.',
    //         'date_naiss.required' => 'La date de naissance est requise.',
    //         'date_naiss.date' => 'La date de naissance doit être une date valide.',
    //         'date_naiss.before' => 'La date de naissance doit être antérieure à aujourd’hui.',
    //         'lieu_naiss.required' => 'Le lieu de naissance est requis.',

    //         // Données administratives
    //         'matricule.required' => 'Le matricule est requis.',
    //         'matricule.unique' => 'Ce matricule est déjà utilisé.',
    //         'statut.required' => 'Le statut est requis.',

    //         // Rattachement
    //         'rattachement_type.required' => 'Le type de rattachement est requis.',
    //         'rattachement_type.in' => 'Le type de rattachement doit être "direction" ou "service".',
    //         'direction_id.required_if' => 'La direction est requise si le rattachement est de type "direction".',
    //         'direction_id.exists' => 'La direction sélectionnée est invalide.',
    //         'parent_direction_id.required_if' => 'La direction principale est requise si le rattachement est de type "service".',
    //         'parent_direction_id.exists' => 'La direction principale sélectionnée est invalide.',
    //         'service_id.required_if' => 'Le service est requis si le rattachement est de type "service".',
    //         'service_id.exists' => 'Le service sélectionné est invalide.',

    //         // Divers
    //         'is_archived.boolean' => 'Le champ "archivé" doit être vrai ou faux.',

    //         // Utilisateurs
    //         'id_user_create.exists' => 'L’utilisateur créateur est invalide.',
    //         'id_user_update.exists' => 'L’utilisateur modificateur est invalide.',
    //         'id_user_delete.exists' => 'L’utilisateur suppresseur est invalide.',
    //     ];
    // }




}
