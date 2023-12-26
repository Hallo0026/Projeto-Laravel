<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteContato;

class ContatoController extends Controller
{
    public function contato(Request $request) {
        /*
        echo '<pre>';
        print_r($request->all()); // Retorna todos os parâmetros passados na request
        echo '</pre>';

        echo $request->input('nome'); // Retorna um parâmetro específico.
        */

        /*
        $contato = new SiteContato();
        $contato->nome              = $request->input('nome');
        $contato->telefone          = $request->input('telefone');
        $contato->email             = $request->input('email');
        $contato->motivo_contato    = $request->input('motivo_contato');
        $contato->mensagem          = $request->input('mensagem');
        try {
            $contato->save();
            echo 'Contato salvo com sucesso!';
        } catch (\Exception $e) {
            echo 'Erro ao salvar contato: ' . $e->getMessage();
        }
        */

        //$contato = new SiteContato();
        //$contato->fill($request->all());
            // $contato->create($request->all());
        //$contato->save();

        $motivo_contatos = [
            '1' => 'Dúvida',
            '2' => 'Elogio',
            '3' => 'Reclamação'
        ];

        return view('site.contato', [ 'titulo' => 'Contato (teste)', 'motivo_contatos' => $motivo_contatos ]);

    }

    public function salvar(Request $request) {

        // Realizando a validação dos dados recebidos no request
        // O validate espera como primeiro parâmetro um array associativo, onde cada chave deve ser o name dos inputs a serem validados
        $request->validate([
            'nome'              => 'required|min:3|max:50',
            'telefone'          => 'required',
            'email'             => 'required|email',
            'motivo_contato'    => 'required',
            'mensagem'          => 'required|max:2000',
        ]);

        SiteContato::create($request->all());

        return redirect()->route('site.index');

    }

}
