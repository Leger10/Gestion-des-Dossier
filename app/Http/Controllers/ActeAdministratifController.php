<?php

namespace App\Http\Controllers;

use App\Models\ActeAdministratif;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ActeAdministratifController extends Controller
{
// Pour la liste générale des actes
public function index()
{
    $actes = ActeAdministratif::with('agent')->latest()->paginate(10);
    return view('actes_administratifs.index', compact('actes'));
}

// Pour les actes d'un agent spécifique
public function byAgent(Agent $agent)
{
    $actes = $agent->actes_administratifs()->latest()->paginate(10);
    return view('actes_administratifs.index', [
        'actes' => $actes,
        'agent' => $agent
    ]);
}
  public function create()
{
    $agents = Agent::orderBy('nom')->get();
    $agent = request('agent_id') ? Agent::find(request('agent_id')) : null;

    return view('actes_administratifs.create', [
        'agents' => $agents,
        'agent' => $agent
    ]);
}
public function store(Request $request)
{
    try {
        // Validation
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'type' => 'required|string|max:255',
            'reference' => 'required|string|max:255|unique:acte_administratifs,reference',
            'date_acte' => 'required|date',
            'description' => 'nullable|string'
        ]);
        
        // Création manuelle
        $acte = new ActeAdministratif();
        $acte->agent_id = $request->agent_id;
        $acte->type = $request->type;
        $acte->reference = $request->reference;
        $acte->date_acte = $request->date_acte;
        $acte->description = $request->description;
        $acte->save();
        
        return redirect()->route('actes_administratifs.index')
            ->with('success', 'Acte créé!');
            
    } catch (\Exception $e) {
        // Log l'erreur
        Log::error('Erreur création acte: '.$e->getMessage());
        
        // Redirection avec erreur
        return back()->withInput()
            ->with('error', 'Erreur: '.$e->getMessage());
    }
}

public function show($id)
{
    $acte = ActeAdministratif::findOrFail($id);
    $acte->load('agent.documents'); // Charge l'agent et ses documents
    return view('actes_administratifs.show', compact('acte'));
}


public function edit($id)
{
    $acte = ActeAdministratif::findOrFail($id);
    $agents = Agent::all(); // Récupère la liste des agents

    return view('actes_administratifs.edit', compact('acte', 'agents'));
}


public function update(Request $request, ActeAdministratif $acteAdministratif)
{
    $validated = $request->validate([
        'agent_id' => 'required|exists:agents,id',
        'type' => 'required|in:Arrêté,Décision,Note de service',
        'reference' => 'required|unique:acte_administratifs,reference,' . $acteAdministratif->id,
        'date_acte' => 'required|date',
        'description' => 'nullable|string'
    ]);
    
    $acteAdministratif->update($validated);
    
    return redirect()->route('actes_administratifs.index')
        ->with('success', 'Acte administratif mis à jour avec succès!');
}

public function destroy(ActeAdministratif $acteAdministratif)
{
    $acteAdministratif->delete();
    
    return redirect()->route('actes_administratifs.index')
        ->with('success', 'Acte administratif supprimé avec succès!');
}

public function download($id)
{
    $acte = ActeAdministratif::findOrFail($id);
    
    // Créer un PDF ou récupérer le fichier existant
    $pdf = PDF::loadView('actes_administratifs.pdf', compact('acte'));
    
    return $pdf->download("acte-{$acte->reference}.pdf");
}
}
