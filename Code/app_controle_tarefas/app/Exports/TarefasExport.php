<?php

namespace App\Exports;

use App\Models\Tarefa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TarefasExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return Tarefa::all();
        return Tarefa::select('id', 'tarefa', 'data_limite_conclusao')->get();
        //return auth()->user()->tarefas()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tarefa',
            'Data limite de conclusão'
        ];
    }
}
