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
    public function exportRegion(Request $request)
    {
        $agent = Agent::where('rattachement_zone_id', $request->region)->first();
        
        if (isset($agent) || $request->region === 'TOUTES LES REGIONS') {
            return Excel::download(new CsvExport(1, $request->region), 'Liste_regions_CT.xlsx');
        } else {
            flash('Pas de région disponible', 'danger');
            return back();  
        }
        
       
              
    }

    public function exportCommune(Request $request)
    {
        $agent = Agent::where('rattachement_zone_id', $request->collectivite)->first();
        
        if (isset($agent) || $request->collectivite === 'TOUTES LES COMMNUNES') {
            return Excel::download(new CsvExport(2, $request->collectivite), 'Liste_communes.xlsx');
        } else {
            flash('Pas de commune disponible ', 'danger');
            return back();  
        }


    }
}
