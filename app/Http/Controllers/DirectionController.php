<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectionController extends Controller
{
     public function index()
    {
        // Récupère toutes les directions avec leurs services et le nombre d'agents par service
        $directions = Direction::with(['services' => function($query) {
            $query->withCount('agents');
        }])->withCount('services')->get();

        // Calcul des totaux
        $totalDirections = Direction::count();
        $totalServices = Service::count();
        $totalAgents = Agent::count();

        // Récupération des agents par direction
        $agentsParDirection = Direction::withCount(['agents' => function($query) {
            $query->select(DB::raw('count(distinct agents.id)'));
        }])->get()->pluck('agents_count', 'name');

        // Récupération des agents par service
        $agentsParService = Service::withCount('agents')->get()
            ->mapWithKeys(function ($service) {
                return [$service->name => $service->agents_count];
            });

        return view('directions.index', compact(
            'directions',
            'totalDirections',
            'totalServices',
            'totalAgents',
            'agentsParDirection',
            'agentsParService'
        ));
    }


    public function create()
    {
        // La création est gérée via modal, rediriger vers l'index
        return redirect()->route('directions.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:directions,name',
            'description' => 'nullable|string'
        ]);

        Direction::create($validated);

        return redirect()->route('directions.index')
            ->with('success', 'Direction créée avec succès.');
    }

    public function show($id)
    {
        $direction = Direction::with('services')->findOrFail($id);
        return view('admin.structure.show', compact('direction'));
    }

    public function edit($id)
    {
        $direction = Direction::findOrFail($id);
        return response()->json($direction);
    }

    public function update(Request $request, $id)
    {
        $direction = Direction::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:directions,name,'.$direction->id,
            
        ]);

        $direction->update($validated);

        return redirect()->route('directions.index')
            ->with('success', 'Direction mise à jour avec succès');
    }

    public function destroy($id)
    {
        $direction = Direction::findOrFail($id);
        
        // Vérifier s'il y a des services associés
        if ($direction->services()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer : des services y sont associés.');
        }

        $direction->delete();

        return redirect()->route('directions.index')
            ->with('success', 'Direction supprimée avec succès');
    }
}