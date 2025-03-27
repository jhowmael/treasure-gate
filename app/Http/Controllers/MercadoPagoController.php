<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        return $this->createPreference(config('payments.values.monthly')); // Valor do plano mensal
    }

    public function yearlyCheckout()
    {
        return $this->createPreference(config('payments.values.yearly')); // Valor do plano anual
    }

    private function createPreference($value)
    {
        $user = Auth::user(); // Obtém o usuário autenticado
        $data = [
            "notification_url" => "https://ff7f-2804-46dc-420-32aa-b94d-cd88-1d16-1763.ngrok-free.app/webhook", // URL de notificação
            "external_reference" => $user->id, // Defina um identificador único para a transação
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
        $paymentId = $request->input('data.id');

        if (!$paymentId) {
            Log::error('Webhook recebido sem ID de pagamento válido.');
            return response()->json(['error' => 'ID de pagamento não encontrado'], 400);
        }

        $response = Http::withToken($this->accessToken)
            ->get("https://api.mercadopago.com/v1/payments/{$paymentId}");

        if ($response->failed()) {
            Log::error("Erro ao buscar pagamento do Mercado Pago: " . $response->body());
            return response()->json(['error' => 'Erro ao buscar pagamento'], 500);
        }

        $paymentData = $response->json();

        $user = User::find($paymentData['external_reference']);

        $payment = Payment::create([
            'user_id' => $user->id, // Você precisa identificar o usuário
            'external_reference' => $paymentData['external_reference'] ?? '',
            'payer_email' => $user->email ?? '',
            'payer_number' => $user->number ?? '',
            'total_value' => $paymentData['transaction_amount'] ?? 0,
            'mercado_pago_payment_id' => $paymentData['id'],
            'type' => config('payments.typesByValue.' . round($paymentData['transaction_amount']), 2),
            'registered' => now(),
        ]);

        $user->save();  // Salva as alterações feitas no usuário

        Log::info('Pagamento registrado com sucesso:', ['payment' => $payment]);

        return response()->json(['message' => 'Pagamento registrado com sucesso'], 200);
    }
}
