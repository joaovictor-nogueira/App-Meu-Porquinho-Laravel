@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="p-2">
                            <a class="link-offset-2 link-underline link-underline-opacity-0 text-body"
                                href="{{ route('transacoes.index') }}">Transações</a>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('transacoes.edit', $transacao->id) }}" class="btn btn-success me-2 mr-2">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                                <i class="fa-solid fa-trash"></i>
                            </button>


                            {{-- <form id='form_{{ $transacao->id }}'
                                action="{{ route('transacoes.destroy', ['transacao' => $transacao->id]) }}" method="post">
                                @method('DELETE')
                                @csrf

                                <a href="#" class="btn btn-danger"
                                    onclick="document.getElementById('form_{{ $transacao->id }}').submit()">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </form> --}}
                        </div>
                    </div>

                    <div class="card-body">

                        <h3 class="text-center">R$ <strong>{{ number_format($transacao->valor, 2, ',', '.') }}</strong></h3>
                        <span class="text-center">
                            @if ($transacao->tipo == 1)
                                <p>
                                    Entrada <i class="fa-solid fa-arrow-trend-up" style="color: #63E6BE;"></i> |
                                    {{ $transacao->created_at->isoFormat('dddd, D MMMM Y') }}

                                </p>
                            @elseif($transacao->tipo == 2)
                                <p>
                                    Saída <i class="fa-solid fa-arrow-trend-down" style="color: #e20303;"></i> |
                                    {{ $transacao->created_at->isoFormat('dddd, D MMMM Y') }}
                                </p>
                            @else
                                Tipo Desconhecido
                            @endif
                        </span>
                        <p class="text-center mt-0 mb-0">Categoria:
                            <strong>{{ $transacao->categoria->nome ?? 'Sem categoria' }}</strong>
                        </p>

                        <hr>

                        <p class="text-center">
                            @if ($transacao->descricao)
                                <strong>Descrição: </strong>
                                {{ $transacao->descricao }}
                            @else
                                Não foi inserido descrição para esse lançamento
                            @endif
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Exclusão</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Deseja realmente excluir essa transação?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <form id='form_{{ $transacao->id }}'
                        action="{{ route('transacoes.destroy', ['transacao' => $transacao->id]) }}" method="post">
                        @method('DELETE')
                        @csrf

                        <a href="#" class="btn btn-danger"
                            onclick="document.getElementById('form_{{ $transacao->id }}').submit()">
                            Excluir
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
