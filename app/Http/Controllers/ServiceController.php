<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Afficher le formulaire de création de service
    public function create()
    {
        return view('directions.index');
    }

    // Enregistrer un nouveau service
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Créer un service
        Service::create([
            'name' => $request->name,
        ]);

        // Retourner vers la page avec un message de succès
        return redirect()->route('directions.index')->with('success', 'Service créé avec succès');
    }

    // Afficher la liste des services
    public function index()
    {
        $services = Service::all();
        return view('directions.index', compact('services'));
    }
}
