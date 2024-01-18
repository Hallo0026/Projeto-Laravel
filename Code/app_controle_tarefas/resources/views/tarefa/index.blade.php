<style>

    .table th, .table td {
        padding: .7rem !important;
        vertical-align: middle !important;
    }

</style>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header" style="font-size: 1.4rem; font-weight: 700;">
                    <div class="row">
                        <div class="col-3">
                            Tarefas
                        </div>
                        <div class="col-9">
                            <div class="float-right">
                                <a href="{{ route('tarefa.exportar', ['extensao' => 'pdf']) }}" class="mr-4">PDF</a>
                                <a href="{{ route('tarefa.exportar.pdf') }}" target="_blank" class="mr-4">PDF V2</a>
                                <a href="{{ route('tarefa.exportar', ['extensao' => 'csv']) }}" class="mr-4">CSV</a>
                                <a href="{{ route('tarefa.exportar', ['extensao' => 'xlsx']) }}" class="mr-4">XLSX</a>
                                <a href="{{ route('tarefa.create') }}">Nova Tarefa</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table">

                        <thead>
                          <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Tarefa</th>
                            <th scope="col">Data limite conclusão</th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>

                        <tbody>
                            @foreach ($tarefas as $tarefa)
                                <tr>
                                    <th scope="row">{{ $tarefa->id }}</th>
                                    <td>{{ $tarefa->tarefa }}</td>
                                    <td>{{ date('d/m/Y', strtotime($tarefa->data_limite_conclusao)) }}</td>
                                    <td><a href="{{ route('tarefa.edit', $tarefa->id) }}">Editar</a></td>
                                    <td>
                                        <form action="{{ route('tarefa.destroy', ['tarefa' => $tarefa->id]) }}" id="form_{{ $tarefa->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" onclick="document.getElementById('form_{{ $tarefa->id }}').submit()">Excluir</a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <nav>
                        <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="{{ $tarefas->previousPageUrl() }}">Voltar</a></li>

                        @for($i = 1; $i <= $tarefas->lastPage(); $i++)
                            <li class="page-item {{ $tarefas->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $tarefas->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <li class="page-item"><a class="page-link" href="{{ $tarefas->nextPageUrl() }}">Avançar</a></li>
                        </ul>
                    </nav>

                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col-md-8 -->
    </div> <!-- row justify-content-center -->
</div> <!-- container -->
@endsection
