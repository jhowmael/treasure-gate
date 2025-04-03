@extends('layouts.web')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <div class="grid grid-cols-2 gap-3">
      
       
    <div class="arbitrage-card">
        <h2 class="text-xl text-white font-semibold mb-2"><img class="w-7 h-7" src="{{ asset('mexc-logo.svg') }}" alt="MEXC Logo"><strong>MECX    $100</h2>
        <a href="javascript:void(0);"class="button-link mt-auto bg-purple-500 text-white py-2 px-4 rounded-lg">Alterar Saldo</a>
      </div>
      
      <div class="arbitrage-card">
        <h2 class="text-xl text-white font-semibold mb-2"><img class="w-7 h-7" src="{{ asset('gate.io.svg') }}"alt="Gate Logo"><strong>Gate    $100</h2>
        <a href="javascript:void(0);"class="button-link mt-auto bg-purple-500 text-white py-2 px-4 rounded-lg">Alterar Saldo</a>
      </div>

    </div>
  </div>
@endsection
