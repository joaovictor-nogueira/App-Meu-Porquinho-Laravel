@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header mb-3">
                        <div class="row">
                            <div class="">
                                {{ __('Dashboard') }}
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('transacoes.create') }} " class="btn btn-success">Nova transação</a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-0 mr-2 ml-2">
                        @if (session('success'))
                            <div class="alert alert-success mb-0">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger mb-0">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>

                    <div class="card-body mt-1">

                        <div class="text-center mb-3">
                                
                            <p class="text-bold mb-0">Seu Saldo é de</p>
                            <h3>R$ <strong>{{ number_format($saldo, 2, ',', '.') }}</strong></h3>
                            
                        </div>
                        
                        <div class="row text-center align-items-center">

                            <div class="col-12 col-md-6 mb-3">
                                {{-- <img src="img/logo-sem-fundo.png" width="150px" alt=""> --}}
                                <span class="badge bg-light text-dark border p-3 d-block mb-2">
                                    <h5 class="text-bold">Entradas</h5>
                                    <h5 class="mb-0">R$ <span
                                            class="text-success text-bold">{{ number_format($totalEntradas, 2, ',', '.') }}</span>
                                    </h5>
                                </span>
                            </div>
                            
                            <div class="col-12 col-md-6 mb-3">
                                
                                <span class="badge bg-light text-dark border p-3 d-block mb-2">
                                    <h5 class="text-bold">Despesas</h5>
                                    <h5 class="mb-0">R$ <span
                                            class="text-danger text-bold">{{ number_format($totalDespesas, 2, ',', '.') }}</span>
                                    </h5>
                                </span>
                            </div>
                        </div>

                        <hr>

                        <h4 class="text-center">Últimas transações <i class="fa-solid fa-money-bill-transfer fa-rotate-by"
                                style="color: #18e225; --fa-rotate-angle: 125deg;"></i></h4>

                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    <th>Categoria</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transacoes as $transacao)
                                    <tr>
                                        <td><a href="{{ route('transacoes.show', ['transacao' => $transacao->id]) }}"
                                                class="link-offset-2 link-underline link-underline-opacity-0 text-body"><i
                                                    class="fa-solid fa-eye"></i></a></td>
                                        <td>
                                            @if ($transacao->tipo == 1)
                                                <i class="fa-solid fa-arrow-trend-up" style="color: #63E6BE;"></i>
                                            @elseif($transacao->tipo == 2)
                                                <i class="fa-solid fa-arrow-trend-down" style="color: #e20303;"></i>
                                            @else
                                                Tipo Desconhecido
                                            @endif
                                        </td>
                                        <td>R$ {{ number_format($transacao->valor, 2, ',', '.') }}</td>
                                        <td>{{ $transacao->categoria->nome ?? 'Sem categoria' }}</td>
                                        <td>{{ $transacao->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Nenhuma transação encontrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <hr>

                        <p class="text-center"><a href="{{ route('transacoes.index') }}">Ver todas transações</a></p>

                    </div>
                </div>
            </div>
        </div>
    </div>


    
@endsection
