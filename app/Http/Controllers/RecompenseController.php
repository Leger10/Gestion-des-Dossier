<?php

namespace App\Http\Controllers;

use App\Models\Recompense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecompenseController extends Controller
{
    public function index()
    {
        return Recompense::with('agent')->recent()->get();
    }

    public function show($id)
    {
        return Recompense::with('agent')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'type_recompense' => 'required|string|max:255',
            'date_recompense' => 'required|date',
            'motif' => 'nullable|string',
            'statut' => 'required|string|in:en cours,accordée,rejetée',
            'document' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $validated['document'] = $request->file('document')->store('recompenses', 'public');
        }

        $recompense = Recompense::create($validated);
        return response()->json($recompense, 201);
    }

    public function update(Request $request, $id)
    {
        $recompense = Recompense::findOrFail($id);

        $validated = $request->validate([
            'type_recompense' => 'sometimes|string|max:255',
            'date_recompense' => 'sometimes|date',
            'motif' => 'nullable|string',
            'statut' => 'sometimes|string|in:en cours,accordée,rejetée',
            'document' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            if ($recompense->document && Storage::disk('public')->exists($recompense->document)) {
                Storage::disk('public')->delete($recompense->document);
            }

            $validated['document'] = $request->file('document')->store('recompenses', 'public');
        }

        $recompense->update($validated);
        return response()->json($recompense);
    }

    public function destroy($id)
    {
        $recompense = Recompense::findOrFail($id);

        if ($recompense->document && Storage::disk('public')->exists($recompense->document)) {
            Storage::disk('public')->delete($recompense->document);
        }

        $recompense->delete();

        return response()->json(['message' => 'Récompense supprimée.']);
    }

    public function byAgent($agentId)
    {
        return Recompense::byAgent($agentId)->recent()->get();
    }

    public function byStatut($statut)
    {
        return Recompense::byStatut($statut)->recent()->get();
    }
}
