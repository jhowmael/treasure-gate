@extends('layouts.web') 

@section('content')
<div class="flex bg-stone-100 justify-center items-center min-h-screen">
    <div class="card-login w-full max-w-md p-8 rounded-lg">
        <div class="text-center mb-6">
            <h4 class="form text-2xl font-semibold text-white-800">Login</h4>
        </div>
        <div class="space-y-6">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- E-mail -->
                <div>
                    <label for="email" class="form block mb-2 text-sm font-medium text-white-50">E-mail</label>
                    <input type="email" id="email" name="email" required autofocus
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900">
                </div>
                <!-- Senha -->
                <div>
                    <label for="password" class="form block text-sm mt-2 mb-2 font-medium text-white-50">Senha</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900">
                </div>
                <!-- Botão -->
                <div class="mt-6">
                    <button type="submit" class="button-form mt-auto bg-purple-500 text-white py-2 px-4 rounded-lg w-full py-2 px-4">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
@endsection
