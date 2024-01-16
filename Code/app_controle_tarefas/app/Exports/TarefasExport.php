<?php

namespace App\Exports;

use App\Models\Tarefa;
use Maatwebsite\Excel\Concerns\FromCollection;

class TarefasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Tarefa::all();
        return Tarefa::select('tarefa', 'data_limite_conclusao')->get();
        //return auth()->user()->tarefas()->get();
    }
}
