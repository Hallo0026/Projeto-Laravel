<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Super Gestao - @yield('titulo')</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{ asset('css/estilo_basico.css') }}">
    </head>

    <body>
        @include('app.layouts._partials.topo') <!-- Por padrão procura a pasta views -->
        @yield('conteudo')
    </body>
</html>
