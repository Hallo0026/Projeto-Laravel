@extends('app.layouts.basico')

@section('titulo', 'Fornecedor')

@section('conteudo')

    <div class="conteudo-pagina">

        <div class="titulo-pagina-2">
            <p>Fornecedor</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('app.fornecedor.adicionar') }}">Novo</a></li>
                <li><a href="{{ route('app.fornecedor') }}">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            {{ $msg ?? '' }}
            <div style="width: 30%; margin: 0 auto;">
                <form action="{{ route('app.fornecedor.listar') }}" method="POST">
                    @csrf
                    <input type="text" name="nome" id="nome" placeholder="Nome" class="borda-preta">
                    <input type="text" name="site" id="site" placeholder="Site" class="borda-preta">
                    <input type="text" name="uf" id="uf" placeholder="UF" class="borda-preta">
                    <input type="text" name="email" id="email" placeholder="Email" class="borda-preta">
                    <button type="submit">Pesquisar</button>
                </form>
            </div>
        </div>

    </div>

@endsection
