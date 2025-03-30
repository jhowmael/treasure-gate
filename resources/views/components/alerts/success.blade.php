<div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
    <strong class="font-bold">Sucesso!</strong>
    <p>{{ $message }}</p>
</div>


<!----- Exemplo de aplicação.
@if (session('success'))
    <x-alerts.success :message="session('success')" />
@endif
----->

<!----- Como criar 
php artisan make:component Alerts/Success
----->