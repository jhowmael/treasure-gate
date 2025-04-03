@extends('layouts.web') <!-- Referência ao seu layout 'web' -->

@section('content')

<!-- From Uiverse.io by Yaya12085 --> 
 <div  class="flex items-stretch md:items-center ...">
<div class="plan mr-5">
		<div class="inner">
			<span class="pricing">
				<span>
                R$ {{ config('payments.values.monthly') }}<small>/mês</small>
				</span>
			</span>
			<p class="title">Plano de 1 Mês</p>
			<p class="info">Plano mensal para quem precisa de flexibilidade.</p>
			<ul class="features">
				<li>
					<span class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path fill="currentColor" d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
						</svg>
					</span>
					<span><strong>24h </strong>Atendimentos</span>
				</li>
				<li>
					<span class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path fill="currentColor" d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
						</svg>
					</span>
					<span>Área <strong>de membros</strong></span>
				</li>
				<li>
					<span class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path fill="currentColor" d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
						</svg>
					</span>
					<span>Grupo ao vivo de operação no discord</span>
				</li>
			</ul>
			<div class="action">
            <form action="{{ route('monthly-checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="button btn btn-success">Assine Agora</button>
            </form>
			</div>
		</div>
	</div>
    <div class="plan">
    <div class="inner">
			<span class="pricing">
				<span>
                R$ {{ config('payments.values.yearly') }}<small>/ano</small>
				</span>
			</span>
			<p class="title">Plano de 1 Ano</p>
			<p class="info">Aproveite o melhor preço para o plano de 1 ano.</p>
			<ul class="features">
				<li>
					<span class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path fill="currentColor" d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
						</svg>
					</span>
					<span><strong>24h </strong>Atendimentos</span>
				</li>
				<li>
					<span class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path fill="currentColor" d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
						</svg>
					</span>
					<span>Área <strong>de membros</strong></span>
				</li>
				<li>
					<span class="icon">
						<svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
							<path d="M0 0h24v24H0z" fill="none"></path>
							<path fill="currentColor" d="M10 15.172l9.192-9.193 1.415 1.414L10 18l-6.364-6.364 1.414-1.414z"></path>
						</svg>
					</span>
					<span>Grupo ao vivo de operação no discord</span>
				</li>
			</ul>
			<div class="action">
            <form action="{{ route('yearly-checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="button btn btn-success">Assine Agora</button>
            </form>
			</div>
		</div>
    </div>

</div>
@endsection