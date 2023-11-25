<?php

use Illuminate\Support\Facades\Route;

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

//Route::get($uri, $callback);

// '?' à direita do parâmetro informa que ele é opcional, para isso também é necessário definir um valor padrão na variável que recebe o parâmetro

// Chamando a rota utilizando controladores

Route::get('/', [\App\Http\Controllers\PrincipalController::class, 'principal']);
Route::get('/sobre-nos', [\App\Http\Controllers\SobreNosController::class, 'sobreNos']);
Route::get('/contato', [\App\Http\Controllers\ContatoController::class, 'contato']);
Route::get('/login', function(){return 'Login';});


Route::prefix('/app')->group(function() {
    Route::get('/clientes', function(){ return 'Clientes'; });
    Route::get('/fornecedores', function(){ return 'Fornecedores'; });
    Route::get('/produtos', function(){ return 'Produtos'; });
});



/*
// Rota parametrizada
Route::get('/contato/{nome}/{categoria}/{assunto}/{mensagem?}',
function
    (

        string $nome,
        string $categoria,
        string $assunto,
        string $mensagem = "valor padrão mensagem"

    ) {

    echo "Estamos aqui: "   . $nome       . "<br>";
    echo "Categoria:    "   . $categoria  . "<br>";
    echo "Assunto:      "   . $assunto    . "<br>";
    echo "Mensagem:     "   . $mensagem   . "<br>";

});
*/

/*
// Rota parametrizada e utilizando regex
Route::get('/contato/{nome}/{categoria_id?}',

    function(

        string  $nome = 'Desconhecido',
        int     $categoria = 1 // 1 = 'Informação'

    ) {
        echo "Estamos aqui: " . $nome . " - " . $categoria;
    }
)->where('nome', '[A-Za-z]+')->where('categoria_id', '[0-9]+');
*/
