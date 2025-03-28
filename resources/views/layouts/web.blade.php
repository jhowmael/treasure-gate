<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tickers</title>
    <link rel="stylesheet" href="{{ asset('css/web.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.1/tailwind.min.css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<style>


</style>

<body >
<div class="flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="bg-indigo-950 w-64 text-white p-4 space-y-6 fixed inset-y-0 left-0">
        <!-- Logo -->
        <div class="text-2xl font-bold text-purple-400">ZILIANIX</div>
        
        <!-- Menu -->
        <ul class="space-y-4 mt-6">
            <li class="py-2 px-4 rounded bg-purple-600 flex items-center">
                <i class="fas fa-th-large mr-2"></i>
                <a href="{{ route('home') }}">Dashboard</a>
            </li>
            <li class="py-2 px-4 rounded hover:bg-purple-500 flex items-center">
                <i class="fas fa-exchange-alt mr-2"></i>
                <a href="{{ route('operation') }}">Operação</a>
            </li>
            <li class="py-2 px-4 rounded hover:bg-purple-500 flex items-center">
                <i class="fas fa-university mr-2"></i>
                <a href="{{ route('arbitration') }}">Arbitragem</a>
            </li>
            <li class="py-2 px-4 rounded hover:bg-purple-500 flex items-center">
                <i class="fas fa-user mr-2"></i>
                <a href="">Conta</a>
            </li>
            <li class="py-2 px-4 rounded hover:bg-purple-500 flex items-center">
                <i class="fas fa-cogs mr-2"></i>
                <a href="">Configuração</a>
            </li>
            <li class="py-2 px-4 rounded hover:bg-purple-500 flex items-center">
                <i class="fas fa-shield-alt mr-2"></i>
                <a href="">Segurança</a>
            </li>
            <li class="py-2 px-4 rounded hover:bg-purple-500 flex items-center">
                <i class="fas fa-question-circle mr-2"></i>
                <a href="{{ route('help') }}">Central De Ajuda</a>
            </li>
        </ul>
        <style>
    input:checked~.dot {
        transform: translateX(100%);
    }
    .toggle-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: white;
    }
    .toggle-bg {
        transition: background-color 0.3s ease-in-out;
    }
</style>

<div class="toggle-bg">
    <div class="flex flex-row items-center">
        <label for="dark-toggle" class="flex items-center cursor-pointer">
            <div class="mr-3 dark:text-white text-gray-900 font-medium">
                Dark Mode
            </div>
            <div class="relative">
                <input type="checkbox" name="dark-mode" id="dark-toggle" class="checkbox hidden">
                <div class="dark-toggle block border-[1px] dark:border-white border-gray-900 w-14 h-8 rounded-full bg-white transition"></div>
                <div class="dot absolute left-1 top-1 dark:bg-white bg-gray-800 w-6 h-6 rounded-full transition"></div>
            </div>
        </label>
    </div>
</div>

<script>
    const toggle = document.getElementById('dark-toggle');
    const container = document.querySelector('.dark-toggle');
    toggle.addEventListener('change', () => {
        container.style.backgroundColor = toggle.checked ? '#1D1D41' : 'white';
        document.body.style.backgroundColor = toggle.checked ? '#12141D' : 'white';
      
    });
</script>
        
        <!-- User Info -->
        <div class="mt-auto flex items-center space-x-3 p-4 bg-[#292b3a] rounded-lg">
            
            <div>
                <p class="text-sm font-medium">Arthur Ziliani</p>
                <p class="text-xs text-gray-400">Iniciante</p>
                <li class="py-2 px-4 rounded hover:bg-purple-500 flex items-center">
                <i class="fas fa-sign-out-alt mr-2"></i>
                <a href="{{ route('help') }}">SAIR</a>
            </li>
            </div>
            
        </div>
    </aside>
    </div>
    <div class="flex-1 p-6 ml-64">
        <div class="container">
            @yield('content')
        </div>
    </div>
  
    </div>
    
</body>

</html>