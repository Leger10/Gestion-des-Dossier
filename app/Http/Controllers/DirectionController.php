<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;

class DirectionController extends Controller
{


    public function index()
{
    $directions = Direction::withCount('services')->paginate(10);
    
    $directionsServices = Direction::with('services')->get()
        ->mapWithKeys(fn($dir) => [$dir->name => $dir->services->pluck('name')]);
        
    $serviceAgents = Service::withCount('agents')->get()
        ->pluck('agents_count', 'name');
 $totalServices = Service::count(); // ✅ Ajouté ici
    return view('directions.index', compact('directions', 'directionsServices', 'totalServices','serviceAgents'));
}
public function create()
{
    return redirect()->route('directions.index');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // // DEBUG TEMPORAIRE
    // dd($request->all());

    Direction::create([
        'name' => $request->nom,
    ]);

    return redirect()->route('directions.index')->with('success', 'Direction créée avec succès.');
}


    public function show($id)
    {
        // Affichage d'une direction
    }

    public function edit($id)
    {
        // Formulaire d’édition
    }

    public function update(Request $request, $id)
    {
        // Mise à jour
        return redirect()->route('directions.index')->with('success', 'Direction mise à jour avec succès.');
    }

    public function destroy($id)
    {
        // Suppression
        return redirect()->route('directions.index')->with('success', 'Direction supprimée.');
    }
}
