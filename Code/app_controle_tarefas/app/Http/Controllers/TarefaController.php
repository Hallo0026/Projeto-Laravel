<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NovaTarefaMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TarefasExport;

class TarefaController extends Controller
{
    /*public function __construct()
    {
        //$this->middleware('auth');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarefas = Tarefa::where('user_id', auth()->user()->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('tarefa.index', ['tarefas' => $tarefas]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarefa.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $regras = [
            'tarefa' => 'required|max:200',
            'data_limite_conclusao' => 'required|date'
        ];

        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido',
            'tarefa.max' => 'O campo tarefa deve ter no máximo 200 caracteres',
            'data_limite_conclusao.date' => 'O campo data limite de conclusão deve ser uma data válida'
        ];

        $request->validate($regras, $feedback);

        $dados = $request->all('tarefa', 'data_limite_conclusao');
        $dados['user_id'] = auth()->user()->id;
        $tarefa = Tarefa::create($dados);

        $destinatario = auth()->user()->email; // Email do usuário logado
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {

        $user_id = auth()->user()->id;
        $tarefa_user_id = $tarefa->user_id;

        if($user_id != $tarefa_user_id){
            return view('acesso-negado');
        } else {
            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefa $tarefa)
    {

        $regras = [
            'tarefa' => 'required|max:200',
            'data_limite_conclusao' => 'required|date'
        ];

        $feedback = [
            'required' => 'O campo :attribute deve ser preenchido',
            'tarefa.max' => 'O campo tarefa deve ter no máximo 200 caracteres',
            'data_limite_conclusao.date' => 'O campo data limite de conclusão deve ser uma data válida'
        ];

        $request->validate($regras, $feedback);

        $user_id = auth()->user()->id;
        $tarefa_user_id = $tarefa->user_id;

        if($user_id != $tarefa_user_id){
            return view('acesso-negado');
        } else {
            $tarefa->update($request->all('tarefa', 'data_limite_conclusao'));
            return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;
        $tarefa_user_id = $tarefa->user_id;

        if($user_id != $tarefa_user_id){
            return view('acesso-negado');
        } else {
            $tarefa->destroy($tarefa->id);
            return redirect()->route('tarefa.index');
        }
    }


    public function exportar($extensao) {

        if(in_array($extensao, ['xlsx', 'csv', 'pdf'])){
            $nome_arquivo = 'tarefas.' . $extensao;
        } else {
            return redirect()->route('tarefa.index');
        }

        return Excel::download(new TarefasExport, $nome_arquivo);
    }

}
