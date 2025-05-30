<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Agent;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;

class AffectationController extends Controller
{
    // Liste toutes les affectations
    public function index()
    {
        $affectations = Affectation::with(['agent', 'direction', 'service'])->recent()->get();
        return response()->json($affectations);
    }

    // Affiche une seule affectation
    public function show($id)
    {
        $affectation = Affectation::with(['agent', 'direction', 'service'])->findOrFail($id);
        return response()->json($affectation);
    }

    // Crée une nouvelle affectation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'direction_id' => 'required|exists:directions,id',
            'service_id' => 'required|exists:services,id',
            'date_affectation' => 'required|date',
            'type_affectation' => 'required|string|max:255',
        ]);

        $affectation = Affectation::create($validated);
        return response()->json($affectation, 201);
    }

    // Met à jour une affectation existante
    public function update(Request $request, $id)
    {
        $affectation = Affectation::findOrFail($id);

        $validated = $request->validate([
            'agent_id' => 'sometimes|exists:agents,id',
            'direction_id' => 'sometimes|exists:directions,id',
            'service_id' => 'sometimes|exists:services,id',
            'date_affectation' => 'sometimes|date',
            'type_affectation' => 'sometimes|string|max:255',
        ]);

        $affectation->update($validated);
        return response()->json($affectation);
    }

    // Supprime une affectation
    public function destroy($id)
    {
        $affectation = Affectation::findOrFail($id);
        $affectation->delete();

        return response()->json(['message' => 'Affectation supprimée.']);
    }

    // Liste des affectations pour un agent spécifique
    public function byAgent($agentId)
    {
        $affectations = Affectation::byAgent($agentId)->with(['direction', 'service'])->get();
        return response()->json($affectations);
    }

    // Liste des affectations récentes et actives
    public function recentActive()
    {
        $affectations = Affectation::active()->recent()->get();
        return response()->json($affectations);
    }
}
