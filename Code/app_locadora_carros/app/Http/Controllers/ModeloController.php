<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{

    public $modelo;

    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }


    public function index(Request $request)
    {

        $modelos = [];

        if($request->has('atributos_marca')) {
            $atributos_marca = $request->atributos_marca;
            $modelos = $this->modelo->with('marca:id,'.$atributos_marca);
        } else {
            $modelos = $this->modelo->with('marca');
        }

        if($request->has('filtro')) {
            $filtros = explode(';', $request->filtro);
            foreach($filtros as $key => $condicao) {
                $c = explode(':', $condicao);
                $modelos = $modelos->where($c[0], $c[1], $c[2]);
            }
        }

        if($request->has('atributos')) {

            $atributos = $request->atributos;
            $modelos = $modelos->selectRaw($atributos)->get();
            // Para recuperar a marca é necessário passar o marca_id no request dos atributos.

        } else {
            $modelos = $modelos->get();
        }

        return response()->json($modelos, 200);

        //return response()->json($this->modelo->with('marca')->get(), 200);
        // all() -> Cria um objeto de consulta + get() = collection
        // get() -> Retorna uma collection porém com a possibilidade de modificar a consulta

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
            return response()->json(['erro' => 'Impossivel realizar a atualizacao. O recurso solicitado nao existe.'], 404);
        }


        if($request->method() === 'PATCH') {
            return ['teste' => 'Verbo PATCH'];

            $regrasDinamicas = array();

            foreach($modelo->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($modelo->rules());

        } else {
            $request->validate($modelo->rules());
        }

        // Remove o arquivo antigo caso um novo arquivo tenha sido enviado no request
        if($request->file('imagem')) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        $imagem = $request->file('imagem');

        /*
         * 1º parametro: pasta onde será salvo a imagem
         * 2º parametro: disco onde será salvo a imagem
         */
        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        //dd($request->file('imagem'));
        $modelo->fill($request->all());
        $modelo->imagem = $imagem_urn;
        $modelo->save();
        /*
        * O método save pode ser utilizado para criar ou atualizar um registro,
        * dependendo se o ID do registro já existe ou não.
        */

        /*$modelo->update([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);*/

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
