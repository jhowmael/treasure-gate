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

<body>
    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-indigo-950 w-64 text-white p-4 space-y-6 fixed inset-y-0 left-0">
            <!-- Logo -->
            <div class="text-2xl font-bold text-purple-400"><img class="w-25" src="{{ asset('Logo.png') }}"alt="MEXC Logo"></div>

            <!-- Menu -->
            <ul class="space-y-4 mt-6">
                <li class="sider-button w-full py-1 px-4 rounded flex items-center 
                    {{ request()->routeIs('home ') ? 'bg-purple-700' : 'hover:bg-Amber-300' }}">
                    <a href="{{ route('home') }} " class="block w-full"><i class="fas fa-th-large mr-2"></i>Dashboard</a>
                </li>

                <li class="sider-button py-1 px-4 rounded flex items-center 
                    {{ request()->routeIs('operation') ? 'bg-purple-700' : 'hover:bg-amber-300' }}">
                    <a href="{{ route('operation') }}" class="block w-full"><i class="fas fa-exchange-alt mr-2"></i>Operação</a>
                </li>

                <li class="sider-button py-1 px-4 rounded flex items-center 
                    {{ request()->routeIs('arbitration') ? 'bg-purple-700' : 'hover:bg-amber-300' }}">
                    <a href="{{ route('arbitration') }}" class="block w-full"> <i class="fas fa-university mr-2"></i> Arbitragem</a>
                </li>
                <li class="sider-button py-1 px-4 rounded flex items-center 
                    {{ request()->routeIs('wallet') ? 'bg-purple-700' : 'hover:bg-amber-300' }}">
                    <a href="wallet" class="block w-full"> <i class="fas fa-wallet mr-2"></i> Carteira</a>
                </li>
                <li class="sider-button py-1 px-4 rounded flex items-center 
                    {{ request()->routeIs('signatures') ? 'bg-purple-700' : 'hover:bg-amber-300' }}">
                    <a href="{{ route('signatures') }}" class="block w-full"> <i class="fas fa-chart-line mr-2"></i> Assinaturas</a>
                </li>
                <li class="sider-button py-1 px-4 rounded flex items-center 
                    {{ request()->routeIs('account') ? 'bg-purple-700' : 'hover:bg-amber-300' }}">
                    <a href="account" class="block w-full"> <i class="fas fa-user mr-2"></i> Conta</a>
                </li>
                <li class="divider"></li>
                <li class="sider-button py-1 px-4 rounded flex items-center 
                    {{ request()->routeIs('configurations') ? 'bg-purple-700' : 'hover:bg-amber-300' }}">
                    <a href="configurations" class="block w-full"> <i class="fas fa-cogs mr-2"></i> Configuração</a>
                </li>
                <li class="sider-button py-1 px-4 rounded flex items-center 
                    {{ request()->routeIs('help') ? 'bg-purple-700' : 'hover:bg-amber-300' }}">
                    <a href="{{ route('help') }}" class="block w-full"> <i class="fas fa-question-circle mr-2"></i>Ajuda</a>
                </li>
                <div class="toggle-bg">
                <div class="py-2 px-4 rounded flex items-center">
                    <label for="dark-toggle" class="flex items-center cursor-pointer">
                        <div class="mr-3 dark:text-white text-white-900 font-medium">
                        <a href="" class="block w-full"> <i class="fas fa-moon mr-2"></i> Dark Mode</a>
                        </div>
                        <div class="relative">
                            <input type="checkbox" name="dark-mode" id="dark-toggle" class="checkbox hidden">
                            <div class="dark-toggle block border-[1px] dark:border-white border-gray-900 w-14 h-8 rounded-full bg-white transition"></div>
                            <div class="dot absolute left-1 top-1 dark:bg-white bg-gray-800 w-6 h-6 rounded-full transition"></div>
                        </div>
                    </label>
                </div>
            </div>
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

          

            <script>
                const toggle = document.getElementById('dark-toggle');
                const container = document.querySelector('.dark-toggle');
                toggle.addEventListener('change', () => {
                    container.style.backgroundColor = toggle.checked ? '#E0AB40' : 'white';
                    document.body.style.backgroundColor = toggle.checked ? '#1a1a1a' : '#fcffa4';

                });
            </script>

            <!-- User Info -->
            <div class="flex items-center space-x-3">
    <!-- Foto de perfil -->
    <img src="{{ asset('R.png') }}" alt="Foto de Arthur Ziliani" class="w-10 h-10 rounded-full">

    <!-- Informações do usuário -->
    <div>
        <p class="text-sm font-medium">Arthur Ziliani</p>
        <p class="text-xs text-gray-400">Iniciante</p>
    </div>
    <li class="py-2 px-4 rounded hover:bg-purple-500 flex items-center">
    <i class="fas fa-sign-out-alt mr-2"></i>
    <a href="{{ route('help') }}">SAIR</a>
</li>
</div>

<!-- Botão de saída -->

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