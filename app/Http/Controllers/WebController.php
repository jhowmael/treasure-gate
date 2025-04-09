<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class WebController extends Controller
{

        public function home()
        {
            // Simulando os dados que a view espera
            $walletData = [
                'mexc' => 1245.50,
                'gate' => 932.25
            ];
    
            $latestOperation = [
                'bancaInicial' => 1000,
                'lucroFinal' => 18.75,
                'entryProfit' => 3.2,
                'exitProfit' => 15.55
            ];
    
            return view('home', compact('walletData', 'latestOperation'));
        }
    

    public function arbitration()
    {
        return view('arbitration');
    }

    public function operation()
    {
        return view('operation');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function signatures()
    {
        return view('signatures');
    }

    public function help()
    {
        return view('help');
    }

    public function wallet()
    {
        return view('wallet');
    }
    
    public function account()
    {
        return view('account');
    }

    public function configurations()
    {
        return view('configurations');
    }

    public function security()
    {
        return view('security');
    }
}
