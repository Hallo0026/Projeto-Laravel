<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Repositories\ModeloRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Marca;

class ModeloController extends Controller
{

    public $modelo;

    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }


    public function index(Request $request)
    {

        $modeloRepository = new modeloRepository($this->modelo);

        if($request->has('atributos_marca')) {

            $atributos_marca = 'marca:id,'.$request->atributos_marca;
            $modeloRepository->selectAtributosRegistrosRelacionados($atributos_marca);

        } else {
            $modeloRepository->selectAtributosRegistrosRelacionados('marca');
        }

        if($request->has('filtro')) {
            $modeloRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {

            $modeloRepository->selectAtributos($request->atributos);
            // Para recuperar a marca é necessário passar o id no request dos atributos.

        }

        //return response()->json($modeloRepository->getResultado(), 200);
        return response()->json($modeloRepository->getResultadoPaginado(2), 200);

    }


    public function store(Request $request)
    {
        // Por padrão o validate retorna para a página anterior, para alterar isso, o cliente definir o header da requisão Accept como application/json, desta forma será retornado um json com os erros.
        $request->validate($this->modelo->rules());

        $imagem = $request->file('imagem');

        /*
         * 1º parametro: pasta onde será salvo a imagem
         * 2º parametro: disco onde será salvo a imagem
         */
        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        //dd($request->file('imagem'));

        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);

        return response()->json($modelo, 201);
    }


    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);

        if($modelo === null) {
          //return ['erro' => 'Recurso pesquisado nao existe.'];
          return response()->json(['erro' => 'Recurso pesquisado nao existe.'], 404);
        }

        return $modelo;
    }


    public function update(Request $request, $id)
    {
        $modelo = $this->modelo->find($id);

        if($modelo === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($modelo->rules() as $input => $regra) {

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);

        } else {
            $request->validate($modelo->rules());
        }

        $modelo->fill($request->all());

        if($request->file('imagem')) {
            Storage::disk('public')->delete($modelo->imagem);
            $imagem = $request->file('imagem');
            $imagem_urn = $imagem->store('imagens', 'public');
            $modelo->imagem = $imagem_urn;
        }

        $modelo->save();

        return response()->json($modelo, 200);
    }


    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if($modelo === null) {
          //return ['erro' => 'Impossivel realizar a exclusao. O recurso solicitado nao existe.'];
            return response()->json(['erro' => 'Impossivel realizar a exclusao. O recurso solicitado nao existe.'], 404);
        }

        Storage::disk('public')->delete($modelo->imagem);

        $modelo->delete();
        return ['msg' => 'O modelo foi removido com sucesso.'];
    }

}
