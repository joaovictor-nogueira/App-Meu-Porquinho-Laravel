@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 col-md-3 mb-3">
                                <a class="link-offset-2 link-underline link-underline-opacity-0 text-body"
                                    href="{{ route('transacoes.index') }}">Transações</a>
                            </div>
                            <div class="col-md-9">
                                <form action="{{ route('transacoes.index') }}" method="get">
                                    <div class="row gx-2">
                                        <div class="col-12 col-md-4">
                                            <select class="form-control mt-1" name="mes" id="mes">
                                                <option value="">Selecione o Mês</option>
                                                <option value="1">Janeiro</option>
                                                <option value="2">Fevereiro</option>
                                                <option value="3">Março</option>
                                                <option value="4">Abril</option>
                                                <option value="5">Maio</option>
                                                <option value="6">Junho</option>
                                                <option value="7">Julho</option>
                                                <option value="8">Agosto</option>
                                                <option value="9">Setembro</option>
                                                <option value="10">Outubro</option>
                                                <option value="11">Novembro</option>
                                                <option value="12">Dezembro</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4 mt-1">
                                            <select class="form-control" name="ano" id="ano">
                                                <option value="">Selecione o Ano</option>
                                                @for ($i = date('Y'); $i >= 2020; $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4 mt-1">
                                            <button class="btn btn-primary w-100" type="submit">
                                                <i class="fa-solid fa-magnifying-glass"></i> Filtrar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4 class="text-center">Transações <i class="fa-solid fa-money-bill-transfer fa-rotate-by"
                                style="color: #18e225; --fa-rotate-angle: 125deg;"></i></h4>

                        <!-- Mostra a data somente se estiver definida -->
                        @if ($data_request)
                            <h5 class="text-center">
                                <i class="fa-solid fa-calendar-days" style="color: #74C0FC;"></i> Mês: {{ $data_request }}
                            </h5>
                        @endif

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

                        <nav class="d-flex justify-content-center">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link"
                                        href="{{ $transacoes->appends(['data' => request('data')])->previousPageUrl() }}">Voltar</a>
                                </li>

                                @for ($i = 1; $i <= $transacoes->lastPage(); $i++)
                                    <li class="page-item {{ $transacoes->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $transacoes->appends(['data' => request('data')])->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <li class="page-item"><a class="page-link"
                                        href="{{ $transacoes->appends(['data' => request('data')])->nextPageUrl() }}">Avançar</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
