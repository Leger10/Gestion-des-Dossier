<?php

namespace App\Http\Controllers\PageParametre;

use App\User;
use App\Models\Agent;
use App\Models\Region;
use App\Models\Direction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PageDashbordController extends Controller
{
  // Mapping des noms de directions vers leurs abréviations
    private $directionAbbreviations = [
        'Direction Générale des Transmissions et de l\'Information' => 'DGTI',
        'Direction des transmissions' => 'DT',
        'Direction des Systèmes d\'Information' => 'DSI',
        'Direction des études, stratégie et formation' => 'DESF',
        'Direction de l\'information géographique' => 'DIG',
        'Direction administration et suivi des programmes' => 'DASP',
        'Antennes régionales transmissions et informatique' => 'ARTI'
    ];

     public function accueil()
{
    // Récupération paginée des agents
    $agents = Agent::whereNull('deleted_at')->paginate(24);

    // Données de base
    $direction = Agent::where('rattachement_type_id', 1)->whereNull('deleted_at')->get();
    $service = Agent::where('rattachement_type_id', 2)->whereNull('deleted_at')->get();

    // Statistiques globales
    $totalAgents = $agents->total(); // Utilise ->total() pour le total de la pagination
    $totalHommes = $agents->where('sexe', 'Masculin')->count();
    $totalFemmes = $agents->where('sexe', 'Feminin')->count();

    // Statistiques par type
    $totalDirection = $direction->count();
    $directionHommes = $direction->where('sexe', 'Masculin')->count();
    $directionFemmes = $direction->where('sexe', 'Feminin')->count();

    $totalService = $service->count();
    $serviceHommes = $service->where('sexe', 'Masculin')->count();
    $serviceFemmes = $service->where('sexe', 'Feminin')->count();

    // Si tu as une fonction pour grouper les agents par direction/service
    $directionsServices = $this->getDirectionsWithServices();

    // Envoi à la vue
    return view('pages.back-office-agent.accueil', [
        'agents' => $agents,
        'totalAgents' => $totalAgents,
        'totalHommes' => $totalHommes,
        'totalFemmes' => $totalFemmes,

        'totalDirection' => $totalDirection,
        'directionHommes' => $directionHommes,
        'directionFemmes' => $directionFemmes,

        'totalService' => $totalService,
        'serviceHommes' => $serviceHommes,
        'serviceFemmes' => $serviceFemmes,

        'directionsServices' => $directionsServices,
        'directionAgents' => $direction,
        'serviceAgents' => $service,
    ]);
}


    private function groupByCategory($agents)
    {
        $categories = ['I', 'II', 'III', 'Néant'];
        $data = [];

        foreach ($categories as $cat) {
            $filtered = $agents->filter(function ($agent) use ($cat) {
                return ($agent->categorie ?? 'Néant') === $cat;
            });

            $data[$cat] = [
                'hommes' => $filtered->where('sexe', 'Homme')->count(),
                'femmes' => $filtered->where('sexe', 'Femme')->count(),
                'total' => $filtered->count(),
            ];
        }

        return $data;
    }


    private function getAgentStats()
    {
        // Récupération des noms complets des directions
        $directionNames = Direction::pluck('name')->toArray();
            // Récupération des noms de directions
    $directionNames = Direction::pluck('name')->toArray();
        // Conversion des noms en abréviations pour l'affichage
        $directionAbbreviations = array_map(function($name) {
            return $this->directionAbbreviations[$name] ?? $name;
        }, $directionNames);

        return [
            'totalAgents' => Agent::count(),
            'hommesTotal' => Agent::where('sexe', 'Masculin')->count(),
            'femmesTotal' => Agent::where('sexe', 'Feminin')->count(),
            
            'totalDirection' => Agent::whereNull('service')->count(),
            'hommesDirection' => Agent::whereNull('service')->where('sexe', 'Masculin')->count(),
            'femmesDirection' => Agent::whereNull('service')->where('sexe', 'Feminin')->count(),
            
            'totalService' => Agent::whereNotNull('service')->count(),
            'hommesService' => Agent::whereNotNull('service')->where('sexe', 'Masculin')->count(),
            'femmesService' => Agent::whereNotNull('service')->where('sexe', 'Feminin')->count(),
            
            'directionCategories' => $this->getCategoryStats(null),
            'serviceCategories' => $this->getCategoryStats('service'),
            
            'directionRecap' => $this->getDirectionRecap($directionNames),
            'directionNames' => $directionAbbreviations // Abréviations pour l'affichage
        ];
    }

    private function getCategoryStats($type)
    {
        $query = ($type === 'service') 
            ? Agent::whereNotNull('service')
            : Agent::whereNull('service');

        $categories = ['I', 'II', 'III', 'Néant'];
        $stats = [];

        foreach ($categories as $categorie) {
            $stats[$categorie] = [
                'hommes' => $query->clone()
                    ->where('categorie', $categorie)
                    ->where('sexe', 'Masculin')
                    ->count(),
                'femmes' => $query->clone()
                    ->where('categorie', $categorie)
                    ->where('sexe', 'Feminin')
                    ->count(),
                'total' => $query->clone()
                    ->where('categorie', $categorie)
                    ->count()
            ];
        }

        return $stats;
    }

    private function getDirectionRecap($directionNames)
    {
        $recap = [];

        foreach ($directionNames as $fullName) {
            $abbreviation = $this->directionAbbreviations[$fullName] ?? $fullName;
            
            $recap[$abbreviation] = [
                'total' => Agent::where('direction', $fullName)
                    ->whereNull('service')
                    ->count(),
                'hommes' => Agent::where('direction', $fullName)
                    ->whereNull('service')
                    ->where('sexe', 'Masculin')
                    ->count(),
                'femmes' => Agent::where('direction', $fullName)
                    ->whereNull('service')
                    ->where('sexe', 'Feminin')
                    ->count()
            ];
        }

        return $recap;
    }

    // Autres méthodes simplifiées...

  
  
// Dans votre contrôleur
public function refreshDashboardData()
{
    $directionData = $this->getDirectionData();
    $serviceData = $this->getServiceData();
    $directionsSummary = $this->getDirectionsSummary();

    $totals = [
        'totalAgents' => $directionData['total'] + $serviceData['total'],
        'totalHommes' => $directionData['hommes'] + $serviceData['hommes'],
        'totalFemmes' => $directionData['femmes'] + $serviceData['femmes'],
    ];

    return response()->json([
        'direction' => $directionData,
        'service' => $serviceData,
        'totals' => $totals,
        'directionsSummary' => $directionsSummary
    ]);
}
    
    public function getDashboardData()
    {
        // Récupération des données principales
        $directionData = $this->getDirectionData();
        $serviceData = $this->getServiceData();
        $directionsSummary = $this->getDirectionsSummary();

        // Calcul des totaux généraux
        $totals = [
            'totalAgents' => $directionData['total'] + $serviceData['total'],
            'totalHommes' => $directionData['hommes'] + $serviceData['hommes'],
            'totalFemmes' => $directionData['femmes'] + $serviceData['femmes'],
        ];

        return response()->json([
            'direction' => $directionData,
            'service' => $serviceData,
            'totals' => $totals,
            'directionsSummary' => $directionsSummary
        ]);
    }

    private function getDirectionData()
    {
        // Trouver l'ID de la direction DGTI
        $dgtlDirection = Direction::where('abreviation', 'DGTI')->first();
        
        if (!$dgtlDirection) {
            return [
                'total' => 0,
                'hommes' => 0,
                'femmes' => 0,
                'categories' => []
            ];
        }

        $directionId = $dgtlDirection->id;

        // Données pour la direction DGTI
        $total = Agent::where('direction_id', $directionId)->count();
        $hommes = Agent::where('direction_id', $directionId)->where('sexe', 'Masculin')->count();
        $femmes = Agent::where('direction_id', $directionId)->where('sexe', 'Feminin')->count();

        // Récupération par catégorie
        $categories = ['I', 'II', 'III', 'Néant'];
        $categoriesData = [];

        foreach ($categories as $category) {
            $categoriesData[$category] = [
                'hommes' => Agent::where('direction_id', $directionId)
                                ->where('categorie', $category)
                                ->where('sexe', 'Masculin')
                                ->count(),
                'femmes' => Agent::where('direction_id', $directionId)
                                ->where('categorie', $category)
                                ->where('sexe', 'Feminin')
                                ->count()
            ];
        }

        return [
            'total' => $total,
            'hommes' => $hommes,
            'femmes' => $femmes,
            'categories' => $categoriesData
        ];
    }

    private function getServiceData()
    {
        // Trouver l'ID de la direction DGTI
        $dgtlDirection = Direction::where('abreviation', 'DGTI')->first();
        
        if (!$dgtlDirection) {
            return [
                'total' => 0,
                'hommes' => 0,
                'femmes' => 0,
                'categories' => []
            ];
        }

        $directionId = $dgtlDirection->id;

        // Données pour les services (toutes les directions sauf DGTI)
        $total = Agent::where('direction_id', '!=', $directionId)->count();
        $hommes = Agent::where('direction_id', '!=', $directionId)->where('sexe', 'Masculin')->count();
        $femmes = Agent::where('direction_id', '!=', $directionId)->where('sexe', 'Feminin')->count();

        // Récupération par catégorie
        $categories = ['I', 'II', 'III', 'Néant'];
        $categoriesData = [];

        foreach ($categories as $category) {
            $categoriesData[$category] = [
                'hommes' => Agent::where('direction_id', '!=', $directionId)
                                ->where('categorie', $category)
                                ->where('sexe', 'Masculin')
                                ->count(),
                'femmes' => Agent::where('direction_id', '!=', $directionId)
                                ->where('categorie', $category)
                                ->where('sexe', 'Feminin')
                                ->count()
            ];
        }

        return [
            'total' => $total,
            'hommes' => $hommes,
            'femmes' => $femmes,
            'categories' => $categoriesData
        ];
    }

    private function getDirectionsSummary()
    {
        // Récupération des directions DGTI et ses sous-directions
        $dgtlDirection = Direction::where('abreviation', 'DGTI')->first();
        
        if (!$dgtlDirection) {
            return [];
        }

        // Récupérer toutes les directions sous DGTI
        $directions = Direction::where('id', $dgtlDirection->id)
                        ->orWhere('parent_id', $dgtlDirection->id)
                        ->get();

        $summary = [];

        foreach ($directions as $direction) {
            $summary[$direction->abreviation] = [
                'total' => Agent::where('direction_id', $direction->id)->count(),
                'hommes' => Agent::where('direction_id', $direction->id)
                                ->where('sexe', 'Masculin')
                                ->count(),
                'femmes' => Agent::where('direction_id', $direction->id)
                                ->where('sexe', 'Feminin')
                                ->count()
            ];
        }

        return $summary;
    }
    public function ShowUserlist(){


        $users = User:: orderBy('created_at', 'desc')->get();
        // dd($users);
        
        return view('pages.dashbord.show_user_list', compact('users'));
    }

    public function unUtilisateurCreer()
    {

        $users = User::orderBy('created_at', 'desc')
        ->limit(1)->get();
        return view('pages.dashbord.show_user_list', compact('users'));
    }


    public function direcions()
    {
        $id_zone = '1';
        $listeAgent = Agent::onlyTrashed()
                    ->where('rattachement_type_id', 1)->orderBy('created_at', 'asc')->get();
        return view('pages.dashbord.index', compact('listeAgent','id_zone'));
    }

    public function service()
    {
        $id_zone = '2';
        $listeAgent = Agent::onlyTrashed()
                            ->where("rattachement_type_id", '=', 2)->orderBy('created_at', 'desc')->get();
        return view('pages.dashbord.index', compact('listeAgent','id_zone') );
    }

    public function editUserAccount($id)
    {
        $user = User::find($id);

        return view('pages.dashbord.edit_user_account', compact('user'));
    }

    public function agentUpdate()
    {
        $listeAgent = Agent::where("id_user_update", '<>', null)
                            ->orderBy('updated_at', 'desc')->get();

        return view('pages.dashbord.agent_update', compact('listeAgent'));
    }

    public function userUpadate(Request $request, $id)
    {
       
        $this->validate($request, [
            'nom' => 'required|string',
        ]);

        $user = User::find($id);
        if ($request->newsPassword != '') {
            $this->validate($request, [
                'newsPassword' => 'min:6|same:replyPassword',
            ]);
            $user->password =  Hash::make($request->newsPassword);
        } 
               
        $user->name = $request->nom;
        $user->email = $request->email;
        $user->is_admin = $request->radio_type;
        $user->save();

        flash('Mise à jour effectuée avec succès !', 'success');
        if (Auth::user()->is_admin === 1) {
            return redirect()->route('dashbord.utilisateur');
        } else {
            return redirect()->route('accueil');
        }
        
    }

    public function getData()
{
    // Récupérer les agents de la base de données
    $agents = Agent::all();
    
    // Calculer les statistiques
    $directions = [
        'total' => $agents->where('type', 'direction')->count(),
        'hommes' => $agents->where('type', 'direction')->where('sexe', 'Masculin')->count(),
        'femmes' => $agents->where('type', 'direction')->where('sexe', 'Feminin')->count(),
        'categories' => [
            'homme' => [
                'I' => $agents->where('type', 'direction')->where('sexe', 'Masculin')->where('categorie', 'I')->count(),
                'II' => $agents->where('type', 'direction')->where('sexe', 'Masculin')->where('categorie', 'II')->count(),
                'III' => $agents->where('type', 'direction')->where('sexe', 'Masculin')->where('categorie', 'III')->count(),
                'Néant' => $agents->where('type', 'direction')->where('sexe', 'Masculin')->where('categorie', 'Néant')->count(),
            ],
            'femme' => [
                'I' => $agents->where('type', 'direction')->where('sexe', 'Feminin')->where('categorie', 'I')->count(),
                'II' => $agents->where('type', 'direction')->where('sexe', 'Feminin')->where('categorie', 'II')->count(),
                'III' => $agents->where('type', 'direction')->where('sexe', 'Feminin')->where('categorie', 'III')->count(),
                'Néant' => $agents->where('type', 'direction')->where('sexe', 'Feminin')->where('categorie', 'Néant')->count(),
            ]
        ]
    ];
    // Même structure pour les services...
    $services = [
        'total' => $agents->where('type', 'service')->count(),
        'hommes' => $agents->where('type', 'service')->where('sexe', 'Masculin')->count(),
        'femmes' => $agents->where('type', 'service')->where('sexe', 'Feminin')->count(),
        'categories' => [
            'homme' => [
                'I' => $agents->where('type', 'service')->where('sexe', 'Masculin')->where('categorie', 'I')->count(),
                'II' => $agents->where('type', 'service')->where('sexe', 'Masculin')->where('categorie', 'II')->count(),
                'III' => $agents->where('type', 'service')->where('sexe', 'Masculin')->where('categorie', 'III')->count(),
                'Néant' => $agents->where('type', 'service')->where('sexe', 'Masculin')->where('categorie', 'Néant')->count(),
            ],
            'femme' => [
                'I' => $agents->where('type', 'service')->where('sexe', 'Feminin')->where('categorie', 'I')->count(),
                'II' => $agents->where('type', 'service')->where('sexe', 'Feminin')->where('categorie', 'II')->count(),
                'III' => $agents->where('type', 'service')->where('sexe', 'Feminin')->where('categorie', 'III')->count(),
                'Néant' => $agents->where('type', 'service')->where('sexe', 'Feminin')->where('categorie', 'Néant')->count(),
            ]
        ]
    ];
    
    // Répartition par direction spécifique
    $repartition = Direction::all()->map(function($direction) use ($agents) {
        return [
            'nom' => $direction->name,
            'hommes' => $agents->where('direction_id', $direction->id)->where('sexe', 'Masculin')->count(),
            'femmes' => $agents->where('direction_id', $direction->id)->where('sexe', 'Feminin')->count()
        ];
    });
    
    return response()->json([
        'directions' => $directions,
        'services' => $services,
        'repartition' => $repartition
    ]);
    
}

}
