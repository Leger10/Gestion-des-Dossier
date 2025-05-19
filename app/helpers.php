<?php
use App\Models\Service; // Assure-toi que le modèle Service existe bien
use App\Models\Direction;
use App\Models\Agent;
use App\Models\Region;
use App\Models\Province;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

if (!function_exists('flash')) {
    function flash($message, $type = 'success') {
        Session::flash('notification.message', $message);
        Session::flash('notification.type', $type);
    }
}

if (!function_exists('regions')) {
    function regions() {
        return Direction::all();
    }
}

if (!function_exists('provinces')) {
    function provinces($id) {
        return Province::where('region_id', $id)->get();
    }
}

if (!function_exists('formatDateInEnglish')) {
    function formatDateInEnglish($date = null) {
        return $date ? Carbon::parse($date)->format('Y-m-d') : null;
    }
}

if (!function_exists('formatDateInFrench')) {
    function formatDateInFrench($date = null) {
        return $date ? Carbon::parse($date)->format('d-m-Y') : '';
    }
}

if (!function_exists('collectivites')) {
    function collectivites() {
        return Agent::all(); // anciennement Collectivite::all()
    }
}

if (!function_exists('statuts')) {
    function statuts() {
        return collect([
            "Fonctionnaire de CT",
            "Contractuel de CT",
            "Agent de la fonction publique d'État",
            "Agent de la fonction publique parlementaire",
            "Agent de la fonction publique hospitalière",
            "Agent de la fonction publique universitaire",
            "Agent d'un établissement public de l'État",
            "Agent d'un établissement public local",
            "Agent régi par le statut de la police nationale",
            "Agent des eaux et forêts",
            "Autres"
        ]);
    }
}

if (!function_exists('diplomes')) {
    function diplomes() {
        return collect(['CEP', 'BEPC', 'BEP', 'BAC', 'LICENCE', 'MAITRISE', 'DOCTORAT', 'Néant', 'Autres']);
    }
}

if (!function_exists('positions')) {
    function positions() {
        return collect(['En activité', 'En détachement', 'En disponibilité', 'Mis à disposition', 'Autres']);
    }
}

if (!function_exists('sousActivites')) {
    function sousActivites() {
        return collect(['En service', 'Stage de formation', 'Stage de perfectionnement', 'Stage de spécialisation']);
    }
}

if (!function_exists('situationParticuliaires')) {
    function situationParticuliaires() {
        return collect([
            'Néant',
            "Agent formé dans les IRA (concerné par la subvention de l'État sur la période 1er juillet 2013 - 30 juin 2020)",
            "Agent des provinces ex CT redéployées (salaire pris en charge par la CT)",
            "Agent des provinces ex CT redéployées (salaire pris en charge par l'État)",
            'Autres'
        ]);
    }
}

if (!function_exists('categories')) {
    function categories() {
        return collect(['P', 'A et assimilés', 'B et assimilés', 'C et assimilés', 'D et assimilés', 'E et assimilés', 'Néant']);
    }
}

if (!function_exists('echelles')) {
    function echelles() {
        return collect(['A', 'B', 'C', '1', '2', '3', 'Néant']);
    }
}

if (!function_exists('classes')) {
    function classes() {
        return collect(['1ère', '2ème', '3ème', 'Néant']);
    }
}

if (!function_exists('services')) {
    function services()
    {
        return Service::all();
    }
}
