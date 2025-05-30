<?php

namespace App\Http\Controllers;

use App\Models\CongeAbsence;
use App\Models\Agent;
use Illuminate\Http\Request;

class CongeAbsenceController extends Controller
{
    public function index()
    {
        $conges = CongeAbsence::latest()->paginate(10);
        return view('conge_absences.index', compact('conges'));
    }

    public function create(Request $request)
    {
        $agent = Agent::findOrFail($request->agent_id);
        return view('conge_absences.create', compact('agent'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'type' => 'required|in:congé,absence',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'nullable|string',
            'document' => 'nullable|file|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        CongeAbsence::create($data);

        return redirect()->route('dashboard.agents.show', $request->agent_id)
                         ->with('success', 'Congé ou absence enregistré.');
    }

    public function show(CongeAbsence $congeAbsence)
    {
        return view('conge_absences.show', compact('congeAbsence'));
    }

    public function edit(CongeAbsence $congeAbsence)
    {
        return view('conge_absences.edit', compact('congeAbsence'));
    }

    public function update(Request $request, CongeAbsence $congeAbsence)
    {
        $request->validate([
            'type' => 'required|in:congé,absence',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'motif' => 'nullable|string',
            'document' => 'nullable|file|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        $congeAbsence->update($data);

        return redirect()->route('dashboard.agents.show', $congeAbsence->agent_id)
                         ->with('success', 'Congé ou absence mis à jour.');
    }

    public function destroy(CongeAbsence $congeAbsence)
    {
        $congeAbsence->delete();

        return redirect()->route('dashboard.agents.show', $congeAbsence->agent_id)
                         ->with('success', 'Congé ou absence supprimé.');
    }
}
