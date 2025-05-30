<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ActeAdministratifController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SanctionController;
use App\Http\Controllers\RecompenseController;
use App\Http\Controllers\CongeAbsenceController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageParametre\PageController;
use App\Http\Controllers\PageParametre\PageDashbordController;
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Correction : Utilisez PageDashbordController au lieu de DashboardController
Route::get('/dashboard-data', [PageDashbordController::class, 'getDashboardData']);

  Route::get('/v1/dashboard-data', [App\Http\Controllers\PageParametre\PageController::class, 'getData']);
Route::get('/directions/{direction}/services', [ApiController::class, 'getServices'])
    ->where('direction', '[0-9]+');

