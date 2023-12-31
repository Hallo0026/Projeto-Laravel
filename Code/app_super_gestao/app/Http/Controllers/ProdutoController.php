<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\ProdutoDetalhe;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Unidade;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produtos = Item::with(['itemDetalhe', 'fornecedor'])->paginate(6);
        // with para acionar o eager loading.

        /*foreach($produtos as $key => $produto) {

            $produtoDetalhe = ProdutoDetalhe::where('produto_id', $produto->id)->first();

            if(isset($produtoDetalhe)) {
                //print_r($produtoDetalhe->getAttributes());
                $produtos[$key]['comprimento'] = $produtoDetalhe->comprimento;
                $produtos[$key]['largura'] = $produtoDetalhe->largura;
                $produtos[$key]['altura'] = $produtoDetalhe->altura;
            }

        }*/

        return view('app.produto.index', ['produtos' => $produtos, 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $unidades = Unidade::all();
        $fornecedores = Fornecedor::all();

        return view('app.produto.create', ['unidades' => $unidades, 'fornecedores' => $fornecedores]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $regras = [
            'nome'          => 'required|min:3|max:40',
            'descricao'     => 'required|min:3|max:2000',
            'peso'          => 'required|integer',
            'unidade_id'    => 'exists:unidades,id', // Verifica se o parâmetro passado existe na tabela unidades
            'fornecedor_id' => 'exists:fornecedores,id'
        ];

        $feedback = [
            'nome.min'              => 'O campo nome deve conter no mínimo 3 caracteres',
            'nome.max'              => 'O campo nome deve conter no máximo 40 caracteres',
            'descricao.min'         => 'O campo descricao deve conter no mínimo 3 caracteres',
            'descricao.max'         => 'O campo descricao deve conter no máximo 2000 caracteres',
            'peso.integer'          => 'O campo peso deve ser um número inteiro',
            'unidade_id.exists'     => 'A unidade de medida informada não existe',
            'fornecedor_id.exists'  => 'O fornecedor informado não existe',
            'required'              => 'O campo :attribute deve ser preenchido'
        ];

        $request->validate($regras, $feedback);

        Item::create($request->all());
        return redirect()->route('produto.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return view('app.produto.show', ['produto' => $produto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        $unidades = Unidade::all();
        $fornecedores = Fornecedor::all();
        return view('app.produto.edit', ['produto' => $produto, 'unidades' => $unidades, 'fornecedores' => $fornecedores]);
        //return view('app.produto.create', ['produto' => $produto, 'unidades' => $unidades]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $produto)
    {
        /*
        print_r($request->all()); // Payload
        echo '<br>';
        print_r($produto->getAttributes()); // Instância do objeto no estado anterior à modificação
        */

        $regras = [
            'nome'          => 'required|min:3|max:40',
            'descricao'     => 'required|min:3|max:2000',
            'peso'          => 'required|integer',
            'unidade_id'    => 'exists:unidades,id', // Verifica se o parâmetro passado existe na tabela unidades
            'fornecedor_id' => 'exists:fornecedores,id'
        ];

        $feedback = [
            'nome.min'              => 'O campo nome deve conter no mínimo 3 caracteres',
            'nome.max'              => 'O campo nome deve conter no máximo 40 caracteres',
            'descricao.min'         => 'O campo descricao deve conter no mínimo 3 caracteres',
            'descricao.max'         => 'O campo descricao deve conter no máximo 2000 caracteres',
            'peso.integer'          => 'O campo peso deve ser um número inteiro',
            'unidade_id.exists'     => 'A unidade de medida informada não existe',
            'fornecedor_id.exists'  => 'O fornecedor informado não existe',
            'required'              => 'O campo :attribute deve ser preenchido'
        ];

        $request->validate($regras, $feedback);

        $produto->update($request->all());
        return redirect()->route('produto.show', ['produto' => $produto->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
       if($produto->delete()) {
           return redirect()->route('produto.index');
       }
    }
}
