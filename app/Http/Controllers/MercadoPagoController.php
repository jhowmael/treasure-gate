<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Payment;  // Certifique-se de ter a model Payment
use Illuminate\Support\Facades\Hash;

class MercadoPagoController extends Controller
{
  
    private $accessToken;

    public function __construct()
    {
        $this->accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

    }
    
    public function monthlyCheckout()
    {
        return $this->createPreference(6); // Valor do plano mensal
    }

    public function yearlyCheckout()
    {
        return $this->createPreference(1000); // Valor do plano anual
    }

    private function createPreference($value)
    {
        $user = Auth::user(); // Obtém o usuário autenticado
        $data = [
            "notification_url" => "https://40ab-2804-868-d048-1e6b-60a0-79ed-7580-869.ngrok-free.app/webhook", // URL de notificação
            "external_reference" =>$user->id, // Defina um identificador único para a transação
            "items" => [
                [
                    "title" => "Assinatura de plataforma",
                    "quantity" => 1,
                    "currency_id" => "BRL",
                    "unit_price" => $value,
                ]
            ],
            "back_urls" => [
                "success" => "http://127.0.0.1:8000/signatures",
                "failure" => "http://127.0.0.1:8000/signatures",
                "pending" => "http://127.0.0.1:8000/signatures"
            ],
            "auto_return" => "approved",
            "payer" => [
                "name" => $user->name,
                "email" => $user->email,
                "identification" => [
                    "type" => "CPF", 
                    "number" => preg_replace('/\D/', '', $user->number), // Remover caracteres não numéricos
                ],
            ]
        ];
        // Faz a requisição para criar a preferência de pagamento
        $response = Http::withToken($this->accessToken)
            ->post("https://api.mercadopago.com/checkout/preferences", $data);
        // Redireciona para a URL de pagamento
        return redirect($response->json()['init_point']);
    }

    public function webhook(Request $request)
    {
        //CRIAR LÓGICA PARA GERAR PAGAMENTO, E ATUALIZAR STATUS DE PREMIUM DO USUÁRIO
        //TESTE REALIZADO, ESTÁ FUNCIONANDO, ACESSANDO A FUNÇÃO
        /* return User::create([
            'type' => 'default', 
            'name' => 'jonatan',
            'number' => 123123123,
            'email' => 'jonatan.ismaelteste@gmail.com',
            'password' => Hash::make(321123123),
            'status' => 'enabled',
            'registered' => now(),
        ]);
        */
    }
}
