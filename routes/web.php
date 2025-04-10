<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AcessController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WalletController;

Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/arbitration', [WebController::class, 'arbitration'])->name('arbitration');
Route::get('/operation', [WebController::class, 'operation'])->name('operation');
Route::get('/about', [WebController::class, 'about'])->name('about');
Route::get('/contact', [WebController::class, 'contact'])->name('contact');
Route::get('/help', [WebController::class, 'help'])->name('help');
Route::get('/wallet', [WebController::class, 'wallet'])->name('wallet');
Route::get('/account', [WebController::class, 'account'])->name('account');
Route::get('/configurations', [WebController::class, 'configurations'])->name('configurations');
Route::get('/security', [WebController::class, 'security'])->name('security');
Route::get('/signatures', [WebController::class, 'signatures'])->name('signatures');

Route::post('/login', [AcessController::class, 'login']);
Route::get('/login', [AcessController::class, 'showLoginForm'])->name('login');
Route::post('/register', [AcessController::class, 'register'])->name('register');
Route::get('/register', [AcessController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); 
})->name('logout');

Route::post('/monthly-checkout', [MercadoPagoController::class, 'monthlyCheckout'])->name('monthly-checkout');
Route::post('/yearly-checkout', [MercadoPagoController::class, 'yearlyCheckout'])->name('yearly-checkout');
Route::post('/wallet/update', [WalletController::class, 'update'])->name('wallet.update');
Route::post('/webhook', [MercadoPagoController::class, 'webhook'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('webhook');

Route::get('/mercadopago-payments', [MercadoPagoController::class, 'mercadopagoPayments'])->name('mercadopago-payments');


Route::get('/get_gateio_tickers', [ApiController::class, 'getGateioTickers']);
Route::get('/get_macx_tickersperpetuo', [ApiController::class, 'getMacxTickers']);
Route::post('/save_arbitrage_data', 'ArbitrageController@saveArbitrageData')->name('arbitrage.saveData');
Route::get('/arbitrage-saved', 'ArbitrageController@showSavedArbitrage')->name('arbitrage.saved');


