@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header mb-3">
                        <div class="">{{ __('Categorias') }}</div>
                    </div>

                    <div class="card-body mt-1">
                        <div class="row">
                            <!-- Gráfico de Despesas -->
                            <div class="col-12 col-md-6 text-center">
                                <h2>Despesas</h2>
                                @if ($gastosPorCategoria && count($gastosPorCategoria) > 0)
                                    <canvas id="graficoGastosCategoria" width="300" height="300"
                                        style="max-width: 300px; max-height: 300px; margin: 0 auto;"></canvas>
                                @else
                                    <p>Não há despesas cadastradas no momento!</p>
                                @endif
                            </div>

                            <!-- Gráfico de Entradas -->
                            <div class="col-12 col-md-6 text-center">
                                <h2>Entradas</h2>
                                @if ($entradasPorCategoria && count($entradasPorCategoria) > 0)
                                    <canvas id="graficoEntradasCategoria" width="300" height="300"
                                        style="max-width: 300px; max-height: 300px; margin: 0 auto;"></canvas>
                                @else
                                    <p>Não há entradas cadastradas no momento!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dados do gráfico de despesas
        const gastosData = @json($gastosPorCategoria);

        const gastosChartData = {
            labels: gastosData.map(item => item.categoria.nome),
            datasets: [{
                data: gastosData.map(item => item.total),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
            }]
        };

        // Inicializa o gráfico de despesas
        const gastosCtx = document.getElementById('graficoGastosCategoria').getContext('2d');
        new Chart(gastosCtx, {
            type: 'pie',
            data: gastosChartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return `${label}: R$ ${value.toFixed(2).replace('.', ',')}`;
                            }
                        }
                    }
                }
            }
        });

        // Dados do gráfico de entradas
        const entradasData = @json($entradasPorCategoria);

        const entradasChartData = {
            labels: entradasData.map(item => item.categoria.nome),
            datasets: [{
                data: entradasData.map(item => item.total),
                backgroundColor: ['#4BC0C0', '#FFCE56', '#FF6384', '#9966FF', '#36A2EB', '#FF9F40']
            }]
        };

        // Inicializa o gráfico de entradas
        const entradasCtx = document.getElementById('graficoEntradasCategoria').getContext('2d');
        new Chart(entradasCtx, {
            type: 'pie',
            data: entradasChartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                return `${label}: R$ ${value.toFixed(2).replace('.', ',')}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
