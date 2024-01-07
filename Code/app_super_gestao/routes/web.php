<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Middleware\LogAcessoMiddleware;

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

/* // Adicionando a interceptação do middleware na rota manualmente.
Route::middleware(LogAcessoMiddleware::class)
    -> get('/', [\App\Http\Controllers\PrincipalController::class, 'principal'])
    -> name('site.index');
*/

Route::get('/', [\App\Http\Controllers\PrincipalController::class, 'principal'])-> name('site.index')->middleware('log.acesso');
Route::get('/sobre-nos', [\App\Http\Controllers\SobreNosController::class, 'sobreNos'])->name('site.sobrenos');

Route::get('/contato', [\App\Http\Controllers\ContatoController::class, 'contato'])->name('site.contato');
Route::post('/contato', [\App\Http\Controllers\ContatoController::class, 'salvar'])->name('site.contato');

Route::get('/login/{erro?}', [\App\Http\Controllers\LoginController::class, 'index'])->name('site.login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'autenticar'])->name('site.login');


Route::middleware('autenticacao:padrao,visitante')->prefix('/app')->group(function() {

    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])-> name('app.home');
    Route::get('/sair', [\App\Http\Controllers\LoginController::class, 'sair'])-> name('app.sair');

    // Rotas fornecedores
    Route::get('/fornecedor', [\App\Http\Controllers\FornecedorController::class, 'index'])-> name('app.fornecedor');
    Route::get('/fornecedor/listar', [\App\Http\Controllers\FornecedorController::class, 'listar'])-> name('app.fornecedor.listar');
    Route::post('/fornecedor/listar', [\App\Http\Controllers\FornecedorController::class, 'listar'])-> name('app.fornecedor.listar');
    Route::get('/fornecedor/adicionar', [\App\Http\Controllers\FornecedorController::class, 'adicionar'])-> name('app.fornecedor.adicionar');
    Route::post('/fornecedor/adicionar', [\App\Http\Controllers\FornecedorController::class, 'adicionar'])-> name('app.fornecedor.adicionar');
    Route::get('/fornecedor/editar/{id}/{msg?}', [\App\Http\Controllers\FornecedorController::class, 'editar'])-> name('app.fornecedor.editar');
    Route::get('/fornecedor/excluir/{id}', [\App\Http\Controllers\FornecedorController::class, 'excluir'])-> name('app.fornecedor.excluir');

    // Rotas produtos
    Route::resource('produto', \App\Http\Controllers\ProdutoController::class)->names([
        'index'     => 'produto.index',
        'create'    => 'produto.create',
        'store'     => 'produto.store',
        'show'      => 'produto.show',
        'edit'      => 'produto.edit',
        'update'    => 'produto.update',
        'destroy'   => 'produto.destroy',
    ]);

    // Produtos detalhes
    Route::resource('produto-detalhe', \App\Http\Controllers\ProdutoDetalheController::class)->names([
        'index'     => 'produto-detalhe.index',
        'create'    => 'produto-detalhe.create',
        'store'     => 'produto-detalhe.store',
        'show'      => 'produto-detalhe.show',
        'edit'      => 'produto-detalhe.edit',
        'update'    => 'produto-detalhe.update',
        'destroy'   => 'produto-detalhe.destroy',
    ]);

    Route::resource('cliente', \App\Http\Controllers\ClienteController::class);
    Route::resource('pedido', \App\Http\Controllers\PedidoController::class);
    Route::resource('pedido-produto', \App\Http\Controllers\PedidoProdutoController::class);

});


// Rota de fallback (uma rota em que o usuário é redirecionado caso a rota especificada não seja encontrada)
Route::fallback(function() {
    echo "A rota acessada não existe. <a href='".route('site.index')."'>Clique aqui para retornar à página inicial</a>";
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

/*
// Redirecionamento de rotas
Route::get('/rota1', function() {
    echo 'Rota 1';
})->name('site.rota1');

Route::get('/rota2', function() {
    return redirect()->route('site.rota1');
})->name('site.rota2');
Route::redirect('/rota2', '/rota1');
*/
