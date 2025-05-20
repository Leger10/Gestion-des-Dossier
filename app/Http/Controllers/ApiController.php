<?php
// app/Http/Controllers/ApiController.php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Service;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getServicesByDirection($directionId)
    {
        $services = Service::where('direction_id', $directionId)->get();
        
        if ($services->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun service trouvé pour cette direction'
            ]);
        }

        return response()->json([
            'success' => true,
            'services' => $services
        ]);
    }
}