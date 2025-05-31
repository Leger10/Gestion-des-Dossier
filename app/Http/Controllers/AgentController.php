<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::latest()->paginate(10);
        return view('agents.index', compact('agents'));
    }

    public function create()
    {
        return view('agents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|string|max:1',
            'situation_matrimoniale' => 'nullable|string|max:255',
            'matricule' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:255',
            'date_recrutement' => 'nullable|date',
            'diplome_recrutement' => 'nullable|string|max:255',
            'statut' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'echelon' => 'nullable|string|max:255',
            'indice' => 'nullable|string|max:255',
            'date_prise_de_service' => 'nullable|date',
            'direction_id' => 'nullable|exists:directions,id',
            'service_id' => 'nullable|exists:services,id',
            'document' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $validated['document'] = $request->file('document')->store('agents_documents', 'public');
        }

        $agent = Agent::create($validated);
        Agent::create($request->all());
        return redirect()->route('agents.index')->with('success', 'Agent créé avec succès.');
    }

    public function show(Agent $agent)
    {
        return view('dashboard.agents.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'sexe' => 'nullable|string|max:1',
            'situation_matrimoniale' => 'nullable|string|max:255',
            'matricule' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:255',
            'date_recrutement' => 'nullable|date',
            'diplome_recrutement' => 'nullable|string|max:255',
            'statut' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'grade' => 'nullable|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'echelon' => 'nullable|string|max:255',
            'indice' => 'nullable|string|max:255',
            'date_prise_de_service' => 'nullable|date',
            'direction_id' => 'nullable|exists:directions,id',
            'service_id' => 'nullable|exists:services,id',
            'document' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            if ($agent->document && Storage::disk('public')->exists($agent->document)) {
                Storage::disk('public')->delete($agent->document);
            }
            $validated['document'] = $request->file('document')->store('agents_documents', 'public');
        }

        $agent->update($validated);

        return redirect()->route('agents.index')->with('success', 'Agent mis à jour avec succès.');
    }

    public function destroy(Agent $agent)
    {
        if ($agent->document && Storage::disk('public')->exists($agent->document)) {
            Storage::disk('public')->delete($agent->document);
        }

        $agent->delete();

        return redirect()->route('agents.index')->with('success', 'Agent supprimé avec succès.');
    }

    
    public function restore($id)
{
    $agent = Agent::withTrashed()->findOrFail($id);
    $agent->restore();

    return redirect()->back()->with('success', 'Agent restauré avec succès.');
}

}
