<?php

namespace App\Http\Controllers\PageParametre;

use App\Models\Agent;
use App\Exports\CsvExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Collectivite;
use Maatwebsite\Excel\Facades\Excel;

class ExportCsvController extends Controller
{
    public function exportDirection(Request $request)
{
    // Vérifier si on veut toutes les directions ou une direction spécifique
    if ($request->direction === 'TOUTES LES DIRECTIONS') {
        return Excel::download(new CsvExport(2, ''), 'Liste_directions_CT.xlsx');
    } else {
        // Vérifier s'il y a des agents dans cette direction
        $agentsExist = Agent::whereHas('direction', function($query) use ($request) {
            $query->where('id', $request->direction);
        })->exists();

        if ($agentsExist) {
            return Excel::download(new CsvExport(2, $request->direction), 'Liste_direction_CT.xlsx');
        } else {
            flash('Aucun agent disponible dans cette direction', 'danger');
            return back();
        }
    }
}
        
       
              
 
public function exportService(Request $request)
{
    // Vérifier si on veut tous les services ou un service spécifique
    if ($request->service === 'TOUS LES SERVICES') {
        return Excel::download(new CsvExport(3, ''), 'Liste_services.xlsx');
    } else {
        // Vérifier s'il y a des agents dans ce service
        $agentsExist = Agent::whereHas('service', function($query) use ($request) {
            $query->where('id', $request->service);
        })->exists();

        if ($agentsExist) {
            return Excel::download(new CsvExport(3, $request->service), 'Liste_service.xlsx');
        } else {
            flash('Aucun agent disponible dans ce service', 'danger');
            return back();
        }
    }
}
}
