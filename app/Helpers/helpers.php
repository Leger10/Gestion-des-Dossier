<?php

use App\Models\Agent;
use App\Models\Region;
use App\Models\Province;
use App\Models\Collectivite;
use App\Models\Direction;
use Illuminate\Support\Facades\Session;  // Importation de Session
if(! function_exists('flash')){
    function flash($message, $type='success'){
        Session::flash('notification.message', $message);
        Session::flash('notification.type', $type);
    }
}

if (!function_exists('directions')) {
   
    function directions()
    {
        $directions = Direction::all();
        return $directions;
    }
}

if (!function_exists('provinces')) {
    function provinces($id)
    {
        $provinces = Province::where("region_id", '=', $id)->get();
        return $provinces;
    }
}

if (!function_exists('formatDateInEnglish')) {
    function formatDateInEnglish($date = null)
    {
        if ($date === null) {
            return null;
        } else {
            return Carbon\Carbon::parse($date)->format('Y-m-d');
            // return Carbon\Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
        }
        
    }
}

if (!function_exists('formatDateInFrench')) {
    function formatDateInFrench($date = null)
    {
        if ($date === null) {
            return '';
        } else {
        return Carbon\Carbon::parse($date)->format('d-m-Y');
        // return Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
        }
        
    }
}


if (!function_exists('collectivites')) {
    function collectivites()
    {
        $Agent = Agent::all();
        return $Agent;
    }
}

if (!function_exists('statuts')) {
    function statuts()
    {
        $statuts = collect([ 'Agent de la fonction publique d\'Etat', 'Agent de la fonction publique parlemantaire', 'Agent de la fonction publique hospitalière', 'Agent de la fonction publique universitaire', 'Agent d\'un établissement public de l\'Etat', 'Agent d\'un établissement public local', 'Agent régi par le statut de la police nationale', 'Agent des eaux et forêt', 'Autres']);
        return $statuts;
    }
}

if (!function_exists('diplomes')) {
    function diplomes()
    {
        $diplomes = collect(['CEP', 'BEPC', 'BEP', 'BAC', 'LICENCE', 'MAITRISE', 'DOCTORAT', 'Néant', 'Autres']);
        return $diplomes;
    }
}

if (!function_exists('positions')) {
    function positions()
    {
        $positions = collect(['En activité', 'En détachement', 'En disponibilité', 'Mis à disposition', 'Autres']);
        return $positions;
    }
}

if (!function_exists('sousActivites')) {
    function sousActivites()
    {
        $sousActivites = collect(['En service', 'Stage de formation', 'Stage de perfectionnement', 'Stage de spécialisation']);
        return $sousActivites;
    }
}

if (!function_exists('situationParticuliaires')) {
    function situationParticuliaires()
    {
        $situationParticuliaires = collect(['Néant', 'Agent formé dans les IRA (concerné par la subvention de l\'Etat sur la période 1er juillet 2013 - 30 juin2020)', 'Agent des provinces ex CT redéployées (salaire pris en charge par la CT)', 'Agent des provinces ex CT redéployées (salaire pris en charge par l\'Etat)', 'Autres']);
        return $situationParticuliaires;
    }
}

if (!function_exists('categories')) {
    function categories() {
        return collect(['I', 'II', 'III', 'Autres']);
    }
}



if (!function_exists('echelles')) {
    function echelles()
    {
        $echelles = collect(['A', 'B', 'C','1','2','3','Néant']);
        return $echelles;
    }
}

if (!function_exists('classes')) {
    function classes()
    {
        $classes = collect(['1ère', '2ème', '3ème','Néant']);
        return $classes;
    }
}



