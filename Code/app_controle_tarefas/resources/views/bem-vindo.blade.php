@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Bem-vindo ao Controle de Tarefas</div>

                    <div class="card-body">
                        <p>Seja bem-vindo à nossa aplicação de controle de tarefas. Aqui você poderá gerenciar suas tarefas de forma eficiente e organizada.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth

        <h2>Conteúdo visível somente para usuário autenticado.</h2>

        ID: {{ Auth::user()->id }} <br>
        Nome: {{ Auth::user()->name }} <br>
        Email: {{ Auth::user()->email }} <br>
        Criado em: {{ Auth::user()->created_at }} <br>
        Atualizado em: {{ Auth::user()->updated_at }} <br>

    @endauth

    @guest
        <h2>Conteúdo visível somente para usuário NÃO autenticado.</h2>
    @endguest

@endsection

