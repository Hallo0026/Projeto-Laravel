<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rotas apiResource não possuem os métodos create e edit

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->post('login', [AuthController::class, 'login']);
Route::middleware('api')->post('refresh', [AuthController::class, 'refresh']);

Route::group([
    'middleware' => 'jwt.auth',
    'prefix' => 'v1'
], function($router) {
    Route::post('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('cliente', ClienteController::class);
    Route::apiResource('carro', CarroController::class);
    Route::apiResource('locacao', LocacaoController::class);
    Route::get('marca/{paginar?}', [MarcaController::class, 'index']);
    Route::post('marca', [MarcaController::class, 'store']);
    Route::apiResource('marca/{$paginar?}', MarcaController::class);
    Route::apiResource('modelo', ModeloController::class);
});
