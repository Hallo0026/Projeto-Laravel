<!-- resources/views/acesso-negado.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Acesso Negado') }}</div>

                    <div class="card-body">
                        <p>{{ __('Desculpe, você não tem permissão para acessar esta página.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
