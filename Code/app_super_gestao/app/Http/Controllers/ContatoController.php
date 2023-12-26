<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteContato;
use App\Models\MotivoContato;

class ContatoController extends Controller
{
    public function contato(Request $request) {

        $motivo_contatos = MotivoContato::all();

        return view('site.contato', ['titulo' => 'Contato (teste)', 'motivo_contatos' => $motivo_contatos]);

    }

    public function salvar(Request $request) {

        $regras = [
            'nome' => 'required|min:3|max:40|unique:site_contatos', // Unique por questões de teste.
            'telefone' => 'required',
            'email' => 'email',
            'motivo_contato' => 'required',
            'mensagem' => 'required|max:2000'
        ];

        $feedback = [
            'nome.min'                  => 'O campo nome precisa ter no mínimo 3 caracteres',
            'nome.min'                  => 'O campo nome pode ter no máximo 40 caracteres',
            'nome.unique'               => 'O nome informado já está em uso',
            'email.email'               => 'O campo email precisa ser preenchido com um endereço de email válido',
            'mensagem.max'              => 'O campo mensagem pode ter no máximo 2000 caracteres',
            // Também é possível customizar o erro somente da validação sem definir um input específico.
            'required' => 'O campo :attribute deve ser preenchido'
        ];

        $request->validate($regras, $feedback); // realizar a validação dos dados do formulário recebidos no request

        SiteContato::create($request->all());

        return redirect()->route('site.index');

    }
}
