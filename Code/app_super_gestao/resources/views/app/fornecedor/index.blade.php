<h3>Fornecedor</h3>

{{-- Comentário utilizando o Blade --}}

@php
/*
    // Operador unless
    // Seria algo parecido com isso:
    if(!{condicao}) {}

    {{-- @unless executa se o retorno for false --}}



*/

@endphp

{{-- @dd($foo) -> Imprime um array --}}
@isset($fornecedores)
    Fornecedor: {{ $fornecedores[1]['nome'] }}
    <br>
    Status: {{ $fornecedores[1]['status'] }}
    <br>
    @isset($fornecedores[1]['cnpj'])
        CNPJ: {{ $fornecedores[1]['cnpj'] }}
    @endisset
@endisset

@if ($fornecedores[0]['status'] == 'S')
    Fornecedor ativo
@endif

<br>

@unless($fornecedores[0]['status'] == 'S') <!-- Executa se o retorno da condição for false -->
    Fornecedor inativo
@endunless


@if(count($fornecedores) < 10)

        <h3>Existem alguns fornecedores cadastrados.</h3>

@elseif(count($fornecedores) >= 10)

        <h3>Existem vários fornecedores cadastrados.</h3>

@else

        <h3>Ainda não existem fornecedores cadastrados.</h3>

@endif


