<?php

namespace App\Http\Controllers\PageParametre;

use App\User;
use App\Models\Agent;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PageDashbordController extends Controller
{

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
$totalDirection = Agent::count(); // total des agents
    // Si tu as une fonction pour grouper les agents par direction/service
    $directionsServices = $this->getDirectionsWithServices();
  $totalDirection = Agent::count(); // Exemple : total des agents
    // Envoi à la vue
    return view('pages.back-office-agent.accueil', [
        'agents' => $agents,
        'totalAgents' => $totalAgents,
        'totalHommes' => $totalHommes,
        'totalFemmes' => $totalFemmes,
          'totalDirection',
        'totalDirection' => $totalDirection,
        'directionHommes' => $directionHommes,
        'directionFemmes' => $directionFemmes,
  'totalDirection',
        'totalService' => $totalService,
        'serviceHommes' => $serviceHommes,
        'serviceFemmes' => $serviceFemmes,

        'directionsServices' => $directionsServices,
        'directionAgents' => $direction,
        'serviceAgents' => $service,
    ]);
}


    public function operationUser(){
        return view('pages.dashbord.operationUser');
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

    public function communes()
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

}
