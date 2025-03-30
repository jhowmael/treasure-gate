<div class="bg-red-500 text-white p-4 rounded-lg shadow-md">
    <strong class="font-bold">Erro!</strong>
    <p>{{ $message }}</p>
</div>


<!----- Exemplo de aplicação.
 @if (session('error'))
    <x-alerts.error :message="session('error')" />
@endif ----->

<!----- Como criar 
php artisan make:component Alerts/error
----->