<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public $marca;

    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = $this->marca->all();
        return $marcas;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$marca = Marca::create($request->all());

        $request->validate($this->marca->rules(), $this->marca->feedback()); // Por padrão o validate retorna para a página anterior, para alterar isso, o cliente definir o header da requisão Accept como application/json, desta forma será retornado um json com os erros.

        $marca = $this->marca->create($request->all());
        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);

        if($marca === null) {
          //return ['erro' => 'Recurso pesquisado nao existe.'];
          return response()->json(['erro' => 'Recurso pesquisado nao existe.'], 404);
        }

        return $marca;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);

        if($marca === null) {
          //return ['erro' => 'Impossivel realizar a atualizacao. O recurso solicitado nao existe.'];
            return response()->json(['erro' => 'Impossivel realizar a atualizacao. O recurso solicitado nao existe.'], 404);
        }

        $request->validate($this->marca->rules(), $this->marca->feedback());

        $marca->update($request->all());
        return $marca;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if($marca === null) {
          //return ['erro' => 'Impossivel realizar a exclusao. O recurso solicitado nao existe.'];
            return response()->json(['erro' => 'Impossivel realizar a exclusao. O recurso solicitado nao existe.'], 404);
        }

        $marca->delete();
        return ['msg' => 'A marca foi removida com sucesso.'];
    }

}
