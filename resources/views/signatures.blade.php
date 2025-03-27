@extends('layouts.web') <!-- Referência ao seu layout 'web' -->

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Plano de 1 Mês</h5>
                    <p class="card-text">Plano mensal para quem precisa de flexibilidade.</p>
                    <h3>R$ {{ config('payments.values.monthly') }}</h3>
                    <form action="{{ route('monthly-checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Assine Agora</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Plano de 1 Ano</h5>
                    <p class="card-text">Aproveite o melhor preço para o plano de 1 ano.</p>
                    <h3>R$ {{ config('payments.values.yearly') }}</h3>
                    <form action="{{ route('yearly-checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Assine Agora</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection