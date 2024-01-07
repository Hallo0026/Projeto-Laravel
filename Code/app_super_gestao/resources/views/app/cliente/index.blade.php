@extends('app.layouts.basico')

@section('titulo', 'Cliente')

@section('conteudo')

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <div class="conteudo-pagina">

        <div class="titulo-pagina-2">
            <p>Listagem de Clientes</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('cliente.create') }}">Novo</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 80%; margin: 0 auto;">
                <table border="1" width="100%">

                    <thead>
                        <tr>
                            <th>Nome</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr>

                                <td>{{ $cliente->nome }}</td>

                                <td><a href="{{ route('cliente.show', ['cliente' => $cliente->id]) }}">Visualizar</a></td>
                                <td>
                                    <form action="{{ route('cliente.destroy', ['cliente' => $cliente->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Excluir</button>
                                    </form>
                                </td>
                                <td><a href="{{ route('cliente.edit', ['cliente' => $cliente->id]) }}">Editar</a></td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

                <div style="position: absolute;bottom: 2%;width: inherit;text-align: center;">

                    {{ $clientes->appends($request)->links() }}

                </div>

            </div>
        </div>

    </div>

@endsection
