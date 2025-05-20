<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DirectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; // ✅ Facade correcte


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/directions/{direction}/services', [ApiController::class, 'getServices'])
     ->where('direction', '[0-9]+');