<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DirectionController;
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
// Route::get('deconnexion',[LoginController::class,'logout'])->name('logout');
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
Route::get('mes/agents/regions', 'PageParametre\PageController@mesRegionsAdmin')->name('mesRegionsAdmin');

Route::get('commune', 'PageParametre\PageController@commune')->name('commune');
Route::get('mes/agents/commune', 'PageParametre\PageController@mesCommuneAdmin')->name('mesCommuneSaisirent');

Route::get('ListeProvinceAjax/{id}','PageParametre\PageController@ListeProvincesAjax');
Route::get('ListeCommuneAjax/{id}','PageParametre\PageController@ListeCommunesAjax');
Route::get('EtatCommuneAjax/{id}','PageParametre\PageController@etatCommuneAjax');

// admin

Route::post('download/excel_file_region', 'PageParametre\ExportCsvController@exportRegion')->name('export.region');
Route::post('download/excel_file_commune', 'PageParametre\ExportCsvController@exportCommune')->name('export.commune');

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
Route::resource('directions', DirectionController::class);
Route::resource('services', ServiceController::class);
// Avant


// Après
Route::resource('agent', \App\Http\Controllers\ParametreAdmin\AdminAgentController::class);