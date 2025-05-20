<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Direction;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportService($id)
    {
        // Logique pour exporter les données d’un service
        return response()->json([
            'message' => "Export du service ID $id"
        ]);
    }

    public function exportDirection($id)
    {
        // Logique pour exporter les données d’une direction
        return response()->json([
            'message' => "Export de la direction ID $id"
        ]);
    }
    public function exportFiltered(Request $request)
{
    // Votre logique d'export filtré ici
    // Ou simplement rediriger vers exportByService si c'est la même fonctionnalité
    return $this->exportByService($request);
}
}
