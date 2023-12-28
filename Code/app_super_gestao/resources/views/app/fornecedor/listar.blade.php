@extends('app.layouts.basico')

@section('titulo', 'Fornecedor')

@section('conteudo')

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <div class="conteudo-pagina">

        <div class="titulo-pagina-2">
            <p>Fornecedor - Listar</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('app.fornecedor.adicionar') }}">Novo</a></li>
                <li><a href="{{ route('app.fornecedor') }}">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 80%; margin: 0 auto;">
                <table border="1" width="100%">

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Site</th>
                            <th>UF</th>
                            <th>Email</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($fornecedores as $fornecedor)
                            <tr>
                                <td>{{ $fornecedor->nome }}</td>
                                <td>{{ $fornecedor->site }}</td>
                                <td>{{ $fornecedor->uf }}</td>
                                <td>{{ $fornecedor->email }}</td>
                                <td><a href="{{ route('app.fornecedor.excluir', $fornecedor->id) }}">Excluir</a></td>
                                <td><a href="{{ route('app.fornecedor.editar', $fornecedor->id) }}">Editar</a></td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

                <div style="position: absolute;bottom: 2%;width: inherit;text-align: center;">

                    {{ $fornecedores->appends($request)->links() }}

                    <!--
                    {{ $fornecedores->count() }} - Total de registros por página
                    <br>

                    {{ $fornecedores->total() }} - Total de registros da consulta
                    <br>

                    {{ $fornecedores->firstItem() }} - Número do primeiro registro da página
                    <br>

                    {{ $fornecedores->lastItem() }} - Número do último registro da página
                    <br>

                    {{ $fornecedores->count() }} - Total de registros por página
                    <br>
                    -->

                </div>

            </div>
        </div>

    </div>

@endsection
