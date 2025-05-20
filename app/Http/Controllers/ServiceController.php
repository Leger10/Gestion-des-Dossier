<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
  // Afficher la liste des services
    public function index()
    {
        $services = Service::all();
        return view('directions.index', compact('services'));
    }

     public function create()
    {
        $directions = Direction::all();
        return view('admin.structure.services.create', compact('directions'));
    }


    public function store(Request $request)
{
    $validated = $request->validate([
            'direction_id' => 'required|exists:directions,id',
            'name' => 'required|string|max:50|unique:services,name',
           
        ]);

        Service::create($validated);

    return redirect()->route('directions.index')->with('success', 'Service créé avec succès');
}


    
    

    public function show($id)
    {
        $service = Service::with(['direction', 'agents'])->findOrFail($id);
        return view('directions.index', compact('service'));
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $directions = Direction::all();
        return response()->json([
            'service' => $service,
            'directions' => $directions
        ]);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'direction_id' => 'required|exists:directions,id',
            'name' => 'required|string|max:50|unique:services,name,'.$service->id,
          
        ]);

        $service->update($validated);

        return redirect()->route('services.index')
            ->with('success', 'Service mis à jour avec succès');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        
        // Vérifier s'il y a des agents associés
        if ($service->agents()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer : des agents y sont associés.');
        }

        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service supprimé avec succès');
    }
}
