<?php

use App\Http\Controllers\CatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccineController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user', [UserController::class, 'store']);
Route::get('/user', [\App\Http\Controllers\UserController::class, 'all']);
Route::get('/user/{id}', [\App\Http\Controllers\UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::post('/test',[UserController::class, 'test']);
Route::post('/cat', [CatController::class, 'store']);
Route::get('/cat', [CatController::class, 'all']);
Route::get('/cat/{id}', [CatController::class, 'show']);
Route::put('/cat/{id}', [CatController::class, 'update']);
Route::delete('/cat/{id}', [CatController::class, 'destroy']);
Route::post('/vaccine', [VaccineController::class, 'store']);
Route::get('/vaccine', [VaccineController::class, 'all']);
Route::get('/vaccine/{id}', [VaccineController::class, 'show']);
Route::put('/vaccine/{id}', [VaccineController::class, 'update']);
Route::delete('/vaccine/{id}', [VaccineController::class, 'destroy']);

