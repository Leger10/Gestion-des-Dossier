<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    // Liste toutes les évaluations
    public function index()
    {
        $evaluations = Evaluation::with(['agent', 'evaluateur'])->recent()->get();
        return response()->json($evaluations);
    }

    // Affiche une seule évaluation
    public function show($id)
    {
        $evaluation = Evaluation::with(['agent', 'evaluateur'])->findOrFail($id);
        return response()->json($evaluation);
    }

    // Crée une nouvelle évaluation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'evaluateur_id' => 'required|exists:users,id',
            'date_evaluation' => 'required|date',
            'note' => 'required|numeric|min:0|max:20',
            'commentaire' => 'nullable|string',
        ]);

        $evaluation = Evaluation::create($validated);
        return response()->json($evaluation, 201);
    }

    // Met à jour une évaluation
    public function update(Request $request, $id)
    {
        $evaluation = Evaluation::findOrFail($id);

        $validated = $request->validate([
            'agent_id' => 'sometimes|exists:agents,id',
            'evaluateur_id' => 'sometimes|exists:users,id',
            'date_evaluation' => 'sometimes|date',
            'note' => 'sometimes|numeric|min:0|max:20',
            'commentaire' => 'nullable|string',
        ]);

        $evaluation->update($validated);
        return response()->json($evaluation);
    }

    // Supprime une évaluation
    public function destroy($id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->delete();

        return response()->json(['message' => 'Évaluation supprimée.']);
    }

    // Liste les évaluations d’un agent spécifique
    public function byAgent($agentId)
    {
        $evaluations = Evaluation::byAgent($agentId)->with(['evaluateur'])->recent()->get();
        return response()->json($evaluations);
    }
}
