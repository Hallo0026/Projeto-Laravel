<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\PedidoProduto;

class PedidoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Pedido $pedido)
    {
        $produtos = Produto::all();
        //$pedido->produtos; // Eager loading
        return view('app.pedido_produto.create', ['pedido' => $pedido, 'produtos' => $produtos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pedido $pedido)
    {
        $regras = [
            'produto_id' => 'exists:produtos,id',
            'quantidade' => 'required'
        ];

        $feedback = [
            'produto_id.exists' => 'O produto informado não existe',
            'required' => 'O campo :attribute deve possui um valor válido'
        ];

        $request->validate($regras, $feedback);

        /*
        $pedidoProduto = new PedidoProduto();
        $pedidoProduto->pedido_id = $pedido->id;
        $pedidoProduto->produto_id = $request->get('produto_id');
        $pedidoProduto->save();
        */

        //$pedido->produtos;   // Registros do relacionamento
        /* Inserindo um registro
        $pedido->produtos()->attach( // Objeto que mapeia os registros do relacionamento
            $request->get('produto_id'),
            [
                'quantidade' => $request->get('quantidade'),
            ]
        );*/

        // Inserindo vários registros
        $pedido->produtos()->attach([
            $request->get('produto_id') => ['quantidade' => $request->get('quantidade')],
            /*$request->get('produto_id') => ['quantidade' => $request->get('quantidade')],
            $request->get('produto_id') => ['quantidade' => $request->get('quantidade')],*/
        ]);

        return redirect()->route('pedido-produto.create', ['pedido' => $pedido->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(Pedido $pedido, Produto $produto)
    public function destroy(pedidoProduto $pedidoProduto, $pedido_id)
    {
        // Método convencional
        /*PedidoProduto::where([
            'pedido_id' => $pedido->id,
            'produto_id' => $produto->id
        ])->delete();*/

        // Método utilizando detach (delete pelo relacionamento)
        //$pedido->produtos()->detach($produto->id);

        $pedidoProduto->delete();

        return redirect()->route('pedido-produto.create', ['pedido' => $pedido_id]);
    }
}
