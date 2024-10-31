@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Adicionar Transação</div>

                    <div class="card-body">
                        @component('transacoes._components.form_create_edit', [
                            'categorias' => $categorias
                            ])

                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
