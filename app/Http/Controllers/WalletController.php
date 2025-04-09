<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'exchange' => 'required|in:mexc,gate',
            'amount' => 'required|numeric|min:0',
        ]);

        $userId = auth()->id();
        $path = storage_path('app/saldos.json');

        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }

        $data = json_decode(file_get_contents($path), true);

        $data[$userId] = $data[$userId] ?? ['mexc' => 0, 'gate' => 0];
        $data[$userId][$request->exchange] = $request->amount;

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));

        // Verifica se é uma requisição AJAX/JSON
        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Saldo atualizado!',
                'data' => [
                    'exchange' => $request->exchange,
                    'amount' => $request->amount
                ]
            ]);
        }

        // Mantém o comportamento de redirecionamento para requisições normais
        return redirect()->back()->with('success', 'Saldo atualizado!');
    }
}