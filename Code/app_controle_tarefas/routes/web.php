<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('bem-vindo');
});

Auth::routes(['verify'=>true]);

/*
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('verified');
*/

Route::get('tarefa/exportar/{extensao}', 'App\Http\Controllers\TarefaController@exportar')->middleware('auth')->name('tarefa.exportar');
Route::resource('tarefa', 'App\Http\Controllers\TarefaController')->middleware('auth');

Route::get('/mensagem-teste', function() {
    return new MensagemTesteMail();
    //Mail::to('email@outlook.com')->send(new MensagemTesteMail());
    //return 'E-mail enviado com sucesso!';
});

