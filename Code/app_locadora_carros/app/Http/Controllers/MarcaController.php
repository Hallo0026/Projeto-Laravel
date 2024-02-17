<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Repositories\MarcaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{

    public $marca;

    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $marcaRepository = new MarcaRepository($this->marca);

        if($request->has('atributos_modelos')) {

            $atributos_modelos = 'modelos:id,'.$request->atributos_modelos;
            $atributos_modelos = $atributos_modelos;
            $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);

        } else {
            //$marcas = $this->marca->with('modelos');
            $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
        }

        if($request->has('filtro')) {
            $marcaRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {

            $marcaRepository->selectAtributos($request->atributos);
            // Para recuperar a marca é necessário passar o id no request dos atributos.

        }

        return response()->json($marcaRepository->getResultadoPaginado(3), 200);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->marca->rules(), $this->marca->feedback()); // Por padrão o validate retorna para a página anterior, para alterar isso, o cliente definir o header da requisão Accept como application/json, desta forma será retornado um json com os erros.
        $imagem = $request->file('imagem');

        /*
         * 1º parametro: pasta onde será salvo a imagem
         * 2º parametro: disco onde será salvo a imagem
         */
        $imagem_urn = $imagem->store('imagens', 'public');

        //dd($request->file('imagem'));

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);

        return response()->json($marca, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->with('marcas')->find($id);

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
            return response()->json(['erro' => 'Impossivel realizar a atualizacao. O recurso solicitado nao existe.'], 404);
        }


        if($request->method() === 'PATCH') {
            return ['teste' => 'Verbo PATCH'];

            $regrasDinamicas = array();

            foreach($marca->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($marca->rules(), $marca->feedback());

        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        // Remove o arquivo antigo caso um novo arquivo tenha sido enviado no request
        if($request->file('imagem')) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $imagem = $request->file('imagem');

        /*
         * 1º parametro: pasta onde será salvo a imagem
         * 2º parametro: disco onde será salvo a imagem
         */
        $imagem_urn = $imagem->store('imagens', 'public');

        //dd($request->file('imagem'));

        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;

        /*$marca->update([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);*/
        $marca->save();
        /*
        * O método save pode ser utilizado para criar ou atualizar um registro,
        * dependendo se o ID do registro já existe ou não.
        */

        return response()->json($marca, 200);

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

        Storage::disk('public')->delete($marca->imagem);

        $marca->delete();
        return ['msg' => 'A marca foi removida com sucesso.'];
    }

}
