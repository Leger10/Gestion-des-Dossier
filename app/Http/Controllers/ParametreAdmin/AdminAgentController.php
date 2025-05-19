<?php

namespace App\Http\Controllers\ParametreAdmin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAgentController extends Controller
{
    /**
     * Affiche la liste des agents
     */
    public function index()
    {
        $agents = Agent::with(['direction', 'service'])
                      ->orderBy('name')
                      ->get();

        return view('admin.agents.index', compact('agents'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $directions = Direction::orderBy('name')->get();
        $services = Service::orderBy('name')->get();
        $rattachementTypes = DB::table('rattachement_types')->get();

        return view('page.back-office-agent.create', [
            'directions' => $directions,
            'services' => $services,
            'rattachementTypes' => $rattachementTypes
        ]);
    }

    /**
     * Enregistre un nouvel agent
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|max:100',
            'prenom' => 'required|max:100',
            'sexe' => 'required|in:Masculin,Feminin',
            'matricule' => 'required|unique:agents|max:50',
            'date_naiss' => 'required|date',
            'lieu_naiss' => 'required|max:100',
            'situation_matri' => 'required|max:50',
            'direction_id' => 'required|exists:directions,id',
            'service_id' => 'required|exists:services,id',
            'rattachement_type_id' => 'nullable|exists:rattachement_types,id',
            'date_prise_de_service' => 'required|date',
            'niveau_recrutement' => 'required|max:50',
            'emploi' => 'required|max:100',
            'fonction' => 'required|max:250',
            'statut' => 'required|max:50',
            'categorie' => 'required|max:50',
            'grade' => 'nullable|max:50',
            'classe' => 'nullable|max:50',
            'echelon' => 'nullable|max:50'
        ]);

        try {
            Agent::create($validated);
            return redirect()->route('agents.index')
                           ->with('success', 'Agent créé avec succès');
        } catch (\Exception $e) {
            return back()->withInput()
                       ->with('error', 'Erreur lors de la création: '.$e->getMessage());
        }
    }
}