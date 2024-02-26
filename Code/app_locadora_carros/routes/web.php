<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/marcas', function() {
    return view('app.marcas');
})->name('marcas')->middleware('auth');

Route::get('/modelos', function() {
    return view('app.modelos');
})->name('modelos')->middleware('auth');

Route::get('/clientes', function() {
    return view('app.clientes');
})->name('clientes')->middleware('auth');

Route::get('/carros', function() {
    return view('app.carros');
})->name('carros')->middleware('auth');
