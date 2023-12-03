<h3>Fornecedor</h3>

{{-- Comentário utilizando o Blade --}}

@php
/*
    // Operador unless
    // Seria algo parecido com isso:
    if(!{condicao}) {}

    {{-- @unless executa se o retorno for false --}}

    // if(empty($foo)) {} // Retorna true se a variável estiver vazia, ou seja, contém algum desses valores:
    - ''
    - 0
    - 0.0
    - '0'
    - null
    - false
    - array()
    - $var

*/

@endphp

{{-- @dd($foo) -> Imprime um array --}}
@isset($fornecedores)

    @php /*

    @for ($i = 0; isset($fornecedores[$i]); $i++)

        Fornecedor: {{ $fornecedores[$i]['nome'] ?? '' }}
        <br>

        Status: {{ $fornecedores[$i]['status'] }}
        <br>

        @isset($fornecedores[$i]['cnpj'])

            CNPJ: {{ $fornecedores[$i]['cnpj'] }}
            @empty($fornecedores[$i]['cnpj'])
                - Vazio
            @endempty

        @endisset

        Telefone: ({{$fornecedores[$i]['ddd'] ?? '' }}) {{ $fornecedores[$i]['telefone'] ?? '' }}

        @if ($fornecedores[$i]['status'] == 'S')
            <br> Fornecedor ativo
        @endif

        @unless($fornecedores[$i]['status'] == 'S') <!-- Executa se o retorno da condição for false -->
            <br> Fornecedor inativo
        @endunless

        <hr>

    @endfor

    */ @endphp


    @foreach ($fornecedores as $indice => $fornecedor)

        Fornecedor: {{ $fornecedor['nome'] ?? '' }}
        <br>

        Status: {{ $fornecedor['status'] }}
        <br>

        @isset($fornecedor['cnpj'])

            CNPJ: {{ $fornecedor['cnpj'] }}
            @empty($fornecedor['cnpj'])
                - Vazio
            @endempty

        @endisset

        Telefone: ({{$fornecedor['ddd'] ?? '' }}) {{ $fornecedor['telefone'] ?? '' }}

        @if ($fornecedor['status'] == 'S')
            <br> Fornecedor ativo
        @endif

        @unless($fornecedor['status'] == 'S') <!-- Executa se o retorno da condição for false -->
            <br> Fornecedor inativo
        @endunless

        <hr>

    @endforeach

@endisset



@if(count($fornecedores) < 10)

    <h3>Existem alguns fornecedores cadastrados.</h3>

@elseif(count($fornecedores) >= 10)

    <h3>Existem vários fornecedores cadastrados.</h3>

@else

        <h3>Ainda não existem fornecedores cadastrados.</h3>

@endif


