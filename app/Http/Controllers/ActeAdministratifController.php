<?php

namespace App\Http\Controllers;

use App\Models\ActeAdministratif;
use App\Models\Agent;
use Illuminate\Http\Request;

class ActeAdministratifController extends Controller
{
    public function index(Agent $agent)
{
    $actes = $agent->actes_administratifs()->latest()->paginate(10); // ✅ Correct


    return view('actes_administratifs.index', [
        'agent' => $agent,
        'actes' => $actes,
        'route' => 'actes_administratifs' // ✅ clé du tableau utilisé pour générer les routes
    ]);
}


   public function create(Request $request)
{
    $agent = Agent::findOrFail($request->agent_id);
    return view('actes_administratifs.create', compact('agent'));
}
public function store(Request $request)
{
    $request->validate([
        'agent_id' => 'required|exists:agents,id',
        'reference' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'date_acte' => 'required|date',
        'description' => 'nullable|string',
    ]);

    ActeAdministratif::create([
        'agent_id' => $request->agent_id,
        'reference' => $request->reference,
        'type' => $request->type,
        'date_acte' => $request->date_acte,
        'description' => $request->description,
    ]);

    return redirect()->back()->with('success', 'Acte administratif ajouté avec succès.');
}


public function show(ActeAdministratif $acteAdministratif)
{
    return view('actes_administratifs.show', [
        'acte' => $acteAdministratif->loadMissing('agent')
    ]);
}

public function edit(ActeAdministratif $acteAdministratif)
{
    return view('actes_administratifs.edit', [
        'acte' => $acteAdministratif
    ]);
}

public function update(Request $request, ActeAdministratif $acteAdministratif)
{
    $validated = $request->validate([
        'type' => 'required|string|max:255',
        'reference' => 'required|string|max:255|unique:acte_administratifs,reference,'.$acteAdministratif->id,
        'date_acte' => 'required|date',
        'description' => 'nullable|string'
    ]);

    $acteAdministratif->update($validated);

    return redirect()->route('actes_administratifs.show', $acteAdministratif)
                     ->with('success', 'Acte administratif mis à jour avec succès');
}

public function destroy(ActeAdministratif $acteAdministratif)
{
    $acteAdministratif->delete();
    
    return redirect()->route('actes_administratifs.index')
                     ->with('success', 'Acte administratif supprimé avec succès');
}
}
