<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\PageParametre\PageController;
use App\Http\Controllers\ParametreAdmin\AgentController;
use App\Http\Controllers\ServiceController;
use App\Models\Agent;
use App\Models\Province;
use App\Models\Collectivite;
use App\Models\Service;
use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::prefix('export')->name('export.')->group(function() {
    // Export par direction
    Route::get('/direction/{direction}', [PageController::class, 'exportByDirection'])
         ->name('direction'); // Nom complet sera 'export.direction'
    
    // Export par service
    Route::get('/service/{service}', [PageController::class, 'exportByService'])
         ->name('service'); // Nom complet sera 'export.service'
    // Utilisez :
Route::get('/export/filter', [PageController::class, 'exportByService']);
    // Export avec filtres
    Route::get('/filter', [PageController::class, 'exportFiltered'])
         ->name('filter'); // Nom complet sera 'export.filter'
});

});
Route::prefix('admin')->group(function() {
    Route::resource('directions', 'DirectionController');
    Route::resource('services', 'ServiceController');
});
Route::get('/admin/regions', [PageController::class, 'mesDirectionsAdmin']);
// Route::get('/admin/communes', [PageController::class, 'mesServicesAdmin']);

// Route::prefix('admin')->group(function() {
//     Route::get('/agents/export', 'AgentController@exportAll')->name('agents.export');
//     Route::get('/agents/export/direction/{id}', 'AgentController@exportByDirection')->name('agents.export.direction');
//     Route::get('/agents/export/service/{id}', 'AgentController@exportByService')->name('agents.export.service');
// });


// API pour charger les services
// Supprimez toutes les définitions existantes de ces routes
// Puis ajoutez ceci :


Route::get('/directions/{direction}/services', [ApiController::class, 'getServicesByDirection']);
     
Route::resource('agent', \App\Http\Controllers\ParametreAdmin\AdminAgentController::class);