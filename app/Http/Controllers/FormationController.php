<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::with('agent')->recent()->get();
        return response()->json($formations);
    }

    public function show($id)
    {
        $formation = Formation::with('agent')->findOrFail($id);
        return response()->json($formation);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'intitule' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'organisme' => 'nullable|string|max:255',
            'lieu' => 'nullable|string|max:255',
            'duree' => 'nullable|numeric|min:0',
            'statut' => 'required|string|in:en cours,terminee,annulee',
            'description' => 'nullable|string',
            'attestation' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('attestation')) {
            $validated['attestation'] = $request->file('attestation')->store('attestations', 'public');
        }

        $formation = Formation::create($validated);
        return response()->json($formation, 201);
    }

    public function update(Request $request, $id)
    {
        $formation = Formation::findOrFail($id);

        $validated = $request->validate([
            'intitule' => 'sometimes|string|max:255',
            'date_debut' => 'sometimes|date',
            'date_fin' => 'sometimes|date|after_or_equal:date_debut',
            'organisme' => 'nullable|string|max:255',
            'lieu' => 'nullable|string|max:255',
            'duree' => 'nullable|numeric|min:0',
            'statut' => 'sometimes|string|in:en cours,terminee,annulee',
            'description' => 'nullable|string',
            'attestation' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('attestation')) {
            // Supprimer l'ancien fichier si présent
            if ($formation->attestation && Storage::disk('public')->exists($formation->attestation)) {
                Storage::disk('public')->delete($formation->attestation);
            }

            $validated['attestation'] = $request->file('attestation')->store('attestations', 'public');
        }

        $formation->update($validated);
        return response()->json($formation);
    }

    public function destroy($id)
    {
        $formation = Formation::findOrFail($id);

        // Supprimer le fichier s'il existe
        if ($formation->attestation && Storage::disk('public')->exists($formation->attestation)) {
            Storage::disk('public')->delete($formation->attestation);
        }

        $formation->delete();

        return response()->json(['message' => 'Formation supprimée.']);
    }

    public function byAgent($agentId)
    {
        $formations = Formation::byAgent($agentId)->recent()->get();
        return response()->json($formations);
    }

    public function byStatut($statut)
    {
        $formations = Formation::byStatut($statut)->recent()->get();
        return response()->json($formations);
    }

    public function downloadPdf($id)
{
    $formation = Formation::with('agent')->findOrFail($id);

    $pdf = Pdf::loadView('formations.pdf', compact('formation'));

    return $pdf->download('formation_' . $formation->id . '.pdf');
}
}