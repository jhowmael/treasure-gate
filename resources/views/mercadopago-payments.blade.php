@extends('layouts.web')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">📌 Pagamentos Recebidos</h2>

    <!-- 🔍 Filtros -->
    <div class="row mb-4">
        <div class="col-md-3">
            <input type="text" id="filterId" class="form-control" placeholder="Filtrar por ID">
        </div>
        <div class="col-md-3">
            <input type="text" id="filterEmail" class="form-control" placeholder="Filtrar por Email">
        </div>
        <div class="col-md-3">
            <select id="filterStatus" class="form-control">
                <option value="">Todos os Status</option>
                <option value="approved">Aprovado</option>
                <option value="pending">Pendente</option>
                <option value="rejected">Rejeitado</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary w-100" onclick="filtrarPagamentos()">Filtrar</button>
        </div>
    </div>

    @if(isset($payments) && count($payments) > 0)
        <div class="row row-cols-1 row-cols-md-4 g-4" id="paymentsContainer">
            @foreach ($payments as $payment)
                <div class="col payment-card" 
                     data-id="{{ $payment['id'] ?? '' }}" 
                     data-email="{{ $payment['payer']['email'] ?? '' }}" 
                     data-status="{{ $payment['status'] ?? '' }}">
                    <div class="card shadow-sm p-3">
                        <!-- Informações de pagamento empilhadas -->
                        <div class="mb-2"><strong>ID:</strong> {{ $payment['id'] ?? '-' }}</div>
                        <div class="mb-2">
                            <strong>Status:</strong> 
                            @if($payment['status'] == 'approved')
                                <span class="text-success fw-bold">✔️ Aprovado</span>
                            @elseif($payment['status'] == 'pending')
                                <span class="text-warning fw-bold">⏳ Pendente</span>
                            @else
                                <span class="text-danger fw-bold">❌ {{ ucfirst($payment['status']) }}</span>
                            @endif
                        </div>
                        <div class="mb-2"><strong>Cliente:</strong> {{ $payment['payer']['email'] ?? 'Não informado' }}</div>
                        <div class="mb-2"><strong>Forma de Pagamento:</strong> {{ $payment['payment_method_id'] ?? '-' }}</div>
                        <div class="mb-2"><strong>Valor:</strong> R$ {{ number_format($payment['transaction_amount'] ?? 0, 2, ',', '.') }}</div>
                        <div class="mb-2"><strong>Data de Criação:</strong> 
                            {{ isset($payment['date_created']) ? \Carbon\Carbon::parse($payment['date_created'])->format('d/m/Y H:i') : '-' }}
                        </div>
                        <div class="mb-2"><strong>Referência Externa:</strong> {{ $payment['external_reference'] ?? '-' }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning text-center">
            <h4>⚠ Nenhum pagamento encontrado.</h4>
        </div>
    @endif
</div>

<script>
    function filtrarPagamentos() {
        let idFiltro = document.getElementById('filterId').value.toLowerCase();
        let emailFiltro = document.getElementById('filterEmail').value.toLowerCase();
        let statusFiltro = document.getElementById('filterStatus').value;

        let cards = document.querySelectorAll('.payment-card');

        cards.forEach(card => {
            let id = card.getAttribute('data-id').toLowerCase();
            let email = card.getAttribute('data-email').toLowerCase();
            let status = card.getAttribute('data-status').toLowerCase();

            let exibir = true;

            if (idFiltro && !id.includes(idFiltro)) {
                exibir = false;
            }

            if (emailFiltro && !email.includes(emailFiltro)) {
                exibir = false;
            }

            if (statusFiltro && status !== statusFiltro) {
                exibir = false;
            }

            card.style.display = exibir ? 'block' : 'none';
        });
    }
</script>
@endsection
