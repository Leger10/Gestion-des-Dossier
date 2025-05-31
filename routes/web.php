<?php

use App\Http\Controllers\ActeAdministratifController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\AgentController as ControllersAgentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\PageParametre\PageController;
use App\Http\Controllers\ServiceController;
use App\Models\Agent;
use App\Models\Province;
use App\Http\Controllers\AgentController;
use App\Models\Collectivite;
use App\Models\Service;
use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CongeAbsenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ParametreAdmin\AdminAgentController;
use App\Http\Controllers\RecompenseController;
use App\Http\Controllers\SanctionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/','HomeController@index')->name('index');
Auth::routes();


Route::get('/accueil', [PageController::class, 'accueil'])->name('pages.front-end.accueil');

Route::get('/dashboard/agents', [DashboardController::class, 'index'])->name('dashboard.agents');
Route::get('/dashboard/agents/{agent}', [DashboardController::class, 'show'])->name('dashboard.agent.details');

Route::prefix('admin/agents')->name('admin.agents.')->group(function() {
    Route::get('/', [AdminAgentController::class, 'index'])->name('dashboard');
    Route::get('/nouveau', [AdminAgentController::class, 'create'])->name('create');
    Route::post('/', [AdminAgentController::class, 'store'])->name('store');
    Route::get('/{agent}/edit', [AdminAgentController::class, 'edit'])->name('edit');
     Route::put('/{agent}', [AdminAgentController::class, 'update'])->name('update');
     Route::delete('/{agent}/delete', [AdminAgentController::class, 'destroy'])->name('agent.supp');
Route::get('/agent/{agent}/restore', [AdminAgentController::class, 'restore'])->name('agent.restore');
});

Route::group(['middleware' => ['auth'] ], function(){

Route::post('register', 'Auth\RegisterController@register');

Route::get('/accueil', 'PageParametre\PageController@accueil')->name('accueil');

// Route::get('/home', 'HomeController@index')->name('home');

Route::resource('agent', 'ParametreAdmin\AgentController');

Route::get('editer/agent', 'PageParametre\PageController@editerAgent')->name('editAgent');

Route::get('agents', 'PageParametre\PageController@agentIndex')->name('agents');

Route::get('statistiques/regions', 'PageParametre\StatistiqueController@statistiqueRegion')->name('statistique.region');
Route::get('statistiques/communes', 'PageParametre\StatistiqueController@statistiqueCommune')->name('statistique.commune');

Route::get('regions', 'PageParametre\PageController@regions')->name('regions');
Route::get('mes/agents/regions', 'PageParametre\PageController@mesDirectionsAdmin')->name('mesDirectionsAdmin');

Route::get('commune', 'PageParametre\PageController@commune')->name('commune');
Route::get('mes/agents/services', 'PageParametre\PageController@mesServiceAdmin')->name('mesServicesSaisirent');

Route::get('ListeProvinceAjax/{id}','PageParametre\PageController@ListeProvincesAjax');
Route::get('ListeCommuneAjax/{id}','PageParametre\PageController@ListeCommunesAjax');
Route::get('EtatCommuneAjax/{id}','PageParametre\PageController@etatCommuneAjax');

// admin

// Route::post('download/excel_file_direction', 'PageParametre\ExportCsvController@exportDirection')->name('export.direction');
// Route::post('download/excel_file_service', 'PageParametre\ExportCsvController@exportService')->name('export.service');
// Route::post('download/excel_file_agent', 'PageParametre\ExportCsvController@exportAgent')->name('export.agent');

Route::get('charts', 'PageParametre\PageDashbordController@chart');

Route::get('dashbord/accueil', 'PageParametre\PageDashbordController@accueil')->name('dashbord.accueil');

Route::get('dashbord/regions', 'PageParametre\PageDashbordController@regions')->name('dashbord.region');
Route::get('dashbord/communes', 'PageParametre\PageDashbordController@communes')->name('dashbord.commune');

Route::get('dashbord/liste/utilisateur', 'PageParametre\PageDashbordController@ShowUserlist')->name('dashbord.utilisateur');
Route::get('dashbord/utilisateur_cree', 'PageParametre\PageDashbordController@unUtilisateurCreer')->name('dashbord.utilisateur_cree');

Route::get('dashbord/agent/update', 'PageParametre\PageDashbordController@agentUpdate')->name('dashbord.updat');

Route::get('dashbord/editer/utilisateur/{id}', 'PageParametre\PageDashbordController@editUserAccount')->name('dashbord.edite');

Route::post('dashbord/update/utilisateur{id}', 'PageParametre\PageDashbordController@userUpadate')->name('dashbord.user_upadate');

});

  Route::get('/export/agents', [ExportController::class, 'exportAgents'])
     ->name('export.agents');

// Routes d'export
Route::prefix('export')->name('export.')->group(function() {
    // Export par direction
    Route::get('/direction/{direction}', [PageController::class, 'exportByDirection'])
         ->name('direction');

Route::get('/export-directions', [ExportController::class, 'exportDirection'])
     ->name('export.directions');
    // Export par service
    Route::get('/service/{service}', [PageController::class, 'exportByService'])
         ->name('service');

    Route::get('/all', [PageController::class, 'exportAll'])
         ->name('all');

    Route::get('/filter', [PageController::class, 'exportFiltered'])
         ->name('filter');
});
// Routes agents
Route::resource('agent', AdminAgentController::class);
// Route::post('agent/store', AdminAgentController::class, 'store')->name('agent.add');
Route::get('/agents/archives', [AdminAgentController::class, 'archive'])->name('agent.archive');
// 

Route::put('agent/{agent}/restore', [AdminAgentController::class, 'restore'])->name('agent.restore')->name('agent.restore.get');



// Groupe des routes d'export
Route::prefix('export')->name('export.')->group(function() {
    
    // Export global
    Route::get('/agents', [ExportController::class, 'exportAgents'])
         ->name('agents'); // export.agents

    // Export par direction
    Route::get('/direction/{direction}', [ExportController::class, 'exportByDirection'])
         ->name('direction'); // export.direction

    // Export par service
    Route::get('/service/{service}', [ExportController::class, 'exportByService'])
         ->name('service'); // export.service

    // Export filtré (multiple critères)
    Route::get('/filter', [ExportController::class, 'exportFiltered'])
         ->name('filter'); // export.filter

    // Export tous les agents (si nécessaire)
    Route::get('/all', [ExportController::class, 'exportAll'])
         ->name('all'); // export.all
});

// Routes admin
Route::prefix('admin')->group(function() {
    Route::resource('directions', DirectionController::class);
    Route::resource('services', ServiceController::class);
    Route::get('/regions', [PageController::class, 'mesDirectionsAdmin'])
         ->name('admin.regions');
});
Route::delete('/admin/agents/{agent}', [AdminAgentController::class, 'destroy'])->name('admin.agents.destroy');
// routes/api.php
Route::get('/directions/{direction}/services', [DirectionController::class, 'getServices']);

// Route::prefix('export')->name('export.')->group(function() {
//     // Export par direction
//     Route::get('/direction/{direction}', [ExportController::class, 'exportByDirection'])
//          ->name('direction');
    
//     // Export par service
//     Route::get('/service/{service}', [ExportController::class, 'exportByService'])
//          ->name('service');

//     // Export complet
//     Route::get('/all', [ExportController::class, 'exportAll'])
//          ->name('all');

    // Export filtré
//     Route::get('/filter', [ExportController::class, 'exportFiltered'])
//          ->name('filter');
// });

// API pour charger les services
Route::get('/directions/{direction}/services', [ApiController::class, 'getServicesByDirection'])
     ->name('api.directions.services');


// Routes RESTful
Route::resource('agents',AgentController::class);
Route::resource('actes_administratifs', ActeAdministratifController::class)->except(['index']);
Route::resource('actes_administratifs', ActeAdministratifController::class);
Route::resource('evaluations', EvaluationController::class);
Route::resource('sanctions', SanctionController::class);
Route::resource('recompenses', RecompenseController::class);
Route::resource('conge_absences', CongeAbsenceController::class);
Route::resource('formations', FormationController::class);
Route::resource('affectations', AffectationController::class);
Route::get('/agents/{agent}', [AgentController::class, 'show'])->name('agents.show');
Route::put('/agents/{id}/restore', [AgentController::class, 'restore'])->name('agent.restore');
// Ajoutez cette route pour récupérer les services
Route::get('/get-services', [PageController::class, 'getServices'])->name('get.services');