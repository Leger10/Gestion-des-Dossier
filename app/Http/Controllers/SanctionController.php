<?php

namespace App\Http\Controllers;

use App\Models\Sanction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SanctionController extends Controller
{
    public function index()
    {
        return Sanction::with('agent')->recent()->get();
    }

    public function show($id)
    {
        return Sanction::with('agent')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'type_sanction' => 'required|string|max:255',
            'date_sanction' => 'required|date',
            'motif' => 'nullable|string',
            'statut' => 'required|string|in:en cours,appliquée,annulée',
            'document' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $validated['document'] = $request->file('document')->store('sanctions', 'public');
        }

        $sanction = Sanction::create($validated);
        return response()->json($sanction, 201);
    }

    public function update(Request $request, $id)
    {
        $sanction = Sanction::findOrFail($id);

        $validated = $request->validate([
            'type_sanction' => 'sometimes|string|max:255',
            'date_sanction' => 'sometimes|date',
            'motif' => 'nullable|string',
            'statut' => 'sometimes|string|in:en cours,appliquée,annulée',
            'document' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            if ($sanction->document && Storage::disk('public')->exists($sanction->document)) {
                Storage::disk('public')->delete($sanction->document);
            }

            $validated['document'] = $request->file('document')->store('sanctions', 'public');
        }

        $sanction->update($validated);
        return response()->json($sanction);
    }

    public function destroy($id)
    {
        $sanction = Sanction::findOrFail($id);

        if ($sanction->document && Storage::disk('public')->exists($sanction->document)) {
            Storage::disk('public')->delete($sanction->document);
        }

        $sanction->delete();

        return response()->json(['message' => 'Sanction supprimée.']);
    }

    public function byAgent($agentId)
    {
        return Sanction::byAgent($agentId)->recent()->get();
    }

    public function byStatut($statut)
    {
        return Sanction::byStatut($statut)->recent()->get();
    }
}
