@extends('layouts.web')

@section('content')
   <!-- SALDOS -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-gray-900 rounded-lg p-4 text-white shadow">
        <h3 class="text-sm text-gray-400">Saldo MEXC</h3>
        <p class="text-2xl font-bold">${{ number_format($walletData['mexc'], 2, ',', '.') }}</p>
    </div>
    <div class="bg-gray-900 rounded-lg p-4 text-white shadow">
        <h3 class="text-sm text-gray-400">Saldo Gate.io</h3>
        <p class="text-2xl font-bold">${{ number_format($walletData['gate'], 2, ',', '.') }}</p>
    </div>
</div>

<!-- GRÁFICO -->
<div class="grafico rounded-lg shadow p-4 mb-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Evolução do Lucro $</h2>
    <canvas id="lucroChart" height="100"></canvas>
</div>

<!-- ÚLTIMA OPERAÇÃO -->
<div class="bg-gray-900 text-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Última Operação</h2>
    <ul class="space-y-2 text-sm">
        <li><strong>Banca Inicial:</strong> ${{ $latestOperation['bancaInicial'] }}</li>
        <li><strong>Lucro Final:</strong> ${{ $latestOperation['lucroFinal'] }}</li>
        <li><strong>Lucro Entrada:</strong> {{ $latestOperation['entryProfit'] }}%</li>
        <li><strong>Lucro Saída:</strong> {{ $latestOperation['exitProfit'] }}%</li>
    </ul>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('lucroChart');
        if (!ctx) return;

        const lucroChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Lucro ($)',
                    data: [100, 150, 130, 170, 200, 250],
                    borderColor: '#0E1927',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'top',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function(value) {
                            return '$' + value.toFixed(2);
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    });
</script>
@endpush
