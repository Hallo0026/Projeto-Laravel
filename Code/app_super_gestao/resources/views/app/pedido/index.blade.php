@extends('app.layouts.basico')

@section('titulo', 'Pedido')

@section('conteudo')

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>

    <div class="conteudo-pagina">

        <div class="titulo-pagina-2">
            <p>Listagem de Pedidos</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('pedido.create') }}">Novo</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 80%; margin: 0 auto;">
                <table border="1" width="100%">

                    <thead>
                        <tr>
                            <th>Id Pedido</th>
                            <th>Cliente</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>

                                <td>{{ $pedido->id }}</td>
                                <td>{{ $pedido->cliente_id }}</td>

                                <td><a href="{{ route('pedido.show', ['pedido' => $pedido->id]) }}">Visualizar</a></td>
                                <td>
                                    <form action="{{ route('pedido.destroy', ['pedido' => $pedido->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Excluir</button>
                                    </form>
                                </td>
                                <td><a href="{{ route('pedido.edit', ['pedido' => $pedido->id]) }}">Editar</a></td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

                <div style="position: absolute;bottom: 2%;width: inherit;text-align: center;">

                    {{ $pedidos->appends($request)->links()* }}


                </div>

            </div>
        </div>

    </div>

@endsection
