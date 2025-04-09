@extends('layouts.web') <!-- Referência ao seu layout 'web' -->

@section('content')
<div class="min-h-screen flex items-center justify-center"> <!-- Centralização vertical + horizontal -->
    <div class="flex items-start justify-center gap-8 flex-wrap">
  <!-- Plano Semanal -->
  <div class="plan">
            <div class="inner">
                <span class="pricing">
                    <span>
                        R$ {{ config('payments.values.weekly') }}<small>/Sem</small>
                    </span>
                </span>
                <p class="title">Plano de 1 Semana</p>
                <p class="info">Plano Semanal para quem precisa.</p>
                <ul class="features space-y-2">
                    <li>
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span><strong>24h</strong> Atendimentos</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Área <strong>de membros</strong></span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Grupo ao vivo de operação no Discord</span>
                    </li>
                </ul>
                <div class="action">
    				<form action="{{ route('monthly-checkout') }}" method="POST">
        				@csrf
        				<button type="submit" class="button button-link btn btn-success mx-auto">
            			<strong>ATIVAR PLANO</strong>
       			 		</button>
   					 </form>
				</div>
            </div>
        </div>

        <!-- Plano Mensal -->
        <div class="plan">
            <div class="inner">
                <span class="pricing">
                    <span>
                        R$ {{ config('payments.values.monthly') }}<small>/mês</small>
                    </span>
                </span>
                <p class="title">Plano de 1 Mês</p>
                <p class="info">Plano mensal para quem precisa de flexibilidade.</p>
                <ul class="features space-y-2">
                    <li>
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span><strong>24h</strong> Atendimentos</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Área <strong>de membros</strong></span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Grupo ao vivo de operação no Discord</span>
                    </li>
                </ul>
                <div class="action mt-4">
                    <form action="{{ route('monthly-checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="button button-link btn btn-success"><strong>ATIVAR PLANO</strong></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Plano Anual -->
        <div class="plan">
            <div class="inner">
                <span class="pricing">
                    <span>
                        R$ {{ config('payments.values.yearly') }}<small>/ano</small>
                    </span>
                </span>
                <p class="title">Plano de 1 Ano</p>
                <p class="info">Aproveite o melhor preço para o plano de 1 ano.</p>
                <ul class="features space-y-2">
                    <li>
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span><strong>24h</strong> Atendimentos</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Área <strong>de membros</strong></span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span>Grupo ao vivo de operação no Discord</span>
                    </li>
                </ul>
                <div class="action mt-4">
                    <form action="{{ route('yearly-checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="button button-link btn btn-success"><strong>ATIVAR PLANO</strong></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
