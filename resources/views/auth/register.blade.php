@extends('layouts.web')

@section('content')
<div class="flex bg-stone-100 justify-center items-center min-h-screen">
    <div class="card-login w-full max-w-md p-8 rounded-lg">
        <div class="">
            <div class="text-center mb-6">
                <h4 class="form text-2xl font-semibold text-white-800">Registrar</h4>
            </div>
            <div class="space-y-6">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form block mb-2 text-sm font-medium text-white-50">Nome</label>
                        <input type="text" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900" id="name" name="name" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form block mb-2 text-sm font-medium text-white-50">CPF</label>
                        <input type="text" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900" id="number" name="number" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form block mb-2 text-sm font-medium text-white-50">E-mail</label>
                        <input type="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form block mb-2 text-sm font-medium text-white-50">Senha</label>
                        <input type="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form block mb-2 text-sm font-medium text-white-50">Confirmar Senha</label>
                        <input type="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-900" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="button-form mt-auto bg-purple-500 text-white py-2 px-4 rounded-lg w-full py-2 px-4">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
