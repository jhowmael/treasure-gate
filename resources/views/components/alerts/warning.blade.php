<div class="bg-yellow-500 text-black p-4 rounded-lg shadow-md">
    <strong class="font-bold">Atenção!</strong>
    <p>{{ $message }}</p>
</div>


<!----- Exemplo de aplicação.
@if (session('warning'))
    <x-alerts.warning :message="session('warning')" />
@endif
----->

<!----- Como criar 
php artisan make:component Alerts/Warning
----->