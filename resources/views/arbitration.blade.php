@extends('layouts.web')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@section('content')
    

    <div id="arbitrage-results" class="ticker-container">
        <!-- Os resultados de arbitragem serão exibidos aqui -->
    </div>

    <div id="error-message" class="error"></div>

    <div id="loading-message" class=" inset-0 flex items-center justify-center">
  <img src="loading.gif" alt="Carregando..." class="w-12" />
</div>


    <!-- Incluir a biblioteca JQuery para facilitar a requisição AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openTwoWindowsAndSaveData(link1, link2, currencyPair, buyPrice, sellPrice, profitPercent, baseVolume, volume24, fundingRate) {
    // Armazenar os dados no sessionStorage
    sessionStorage.setItem('clickedCurrencyPair', currencyPair);
    
            sessionStorage.setItem('buyPrice', buyPrice);
            sessionStorage.setItem('sellPrice', sellPrice);
            sessionStorage.setItem('profitPercent', profitPercent);
            sessionStorage.setItem('baseVolume', baseVolume);
            sessionStorage.setItem('volume24', volume24);
            sessionStorage.setItem('fundingRate', fundingRate);

    // Enviar os dados para o backend via AJAX
    $.ajax({
        url: '{{ route('arbitrage.saveData') }}',  // URL onde os dados serão salvos
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',  // Token CSRF
            currency_pair: currencyPair,
            buy_price: buyPrice,
            sell_price: sellPrice,
            profit_percent: profitPercent,
            base_volume: baseVolume,
            volume24: volume24,
            funding_rate: fundingRate
        },
        success: function(response) {
            console.log('Dados de Arbitragem salvos com sucesso!', response);
        },
        error: function(xhr, status, error) {
            console.error('Erro ao salvar dados de arbitragem', xhr, status, error);
        }
    });

    // Agora abrir as janelas de arbitragem como no código original
    var screenWidth = window.innerWidth;
    var screenHeight = window.innerHeight;

    var window1 = window.open(link1, '_blank', 
        'width=' + Math.floor(screenWidth / 2) + 
        ', height=' + screenHeight + 
        ', left=0, top=0');

    var window2 = window.open(link2, '_blank', 
        'width=' + Math.floor(screenWidth / 2) + 
        ', height=' + screenHeight + 
        ', left=' + Math.floor(screenWidth / 2) + 
        ', top=0');
}

        // Função para atualizar os dados da API
        function updateTickers() {
            $('#loading-message').show(); // Exibe o carregando

            // Realiza as duas requisições AJAX de forma independente
            $.ajax({
                url: '{{ url('/get_gateio_tickers') }}', // Rota Laravel Gate.io
                method: 'GET',
                dataType: 'json',
                success: function(responseGateio) {
                    console.log("Resposta da Gate.io:", responseGateio);  // Log da resposta da Gate.io
                    
                    $.ajax({
                        url: '{{ url('/get_macx_tickersperpetuo') }}', // Rota Laravel Macx
                        method: 'GET',
                        dataType: 'json',
                        success: function(responseMacx) {
                            console.log("Resposta da Macx:", responseMacx);  // Log da resposta da Macx

                            // Verifique se a resposta da Macx é um objeto e se contém os dados esperados
                            if (responseMacx && typeof responseMacx === 'object' && responseMacx.data) {
                                console.log("Estrutura da Macx:", responseMacx.data);
                                
                                let macxData = {};
                                let macxTickers = responseMacx.data;

                                macxTickers.forEach(function(tickerMacx) {
                                    let symbolMacx = tickerMacx.symbol.trim().toUpperCase();
                                    macxData[symbolMacx] = tickerMacx;
                                });

                                let arbitrageResultsHTML = '';

                                responseGateio.forEach(function(tickerGateio) {
                                    let gateioSymbol = tickerGateio.currency_pair.trim().toUpperCase();
                                    if (macxData[gateioSymbol]) {
                                        let buyGateio = tickerGateio.lowest_ask;
                                        let sellMacx = macxData[gateioSymbol].bid1;
                                        let base_volume = parseFloat(tickerGateio.base_volume);
                                        let volume24 = parseFloat(macxData[gateioSymbol].volume24);
                                        let fundingRatpercentage = macxData[gateioSymbol].fundingRate * 100;

                                        let profitGateioToMacx = sellMacx - buyGateio;

                                       let Pair = gateioSymbol

                                        Pair = Pair.replace("_","->")

                                        let VolumeGate = new Intl.NumberFormat('en-US', {
                                                     style: 'currency',
                                                    currency: 'USD',  // Definindo a moeda como USD
                                                    minimumFractionDigits: 2,  // Exibe pelo menos 2 casas decimais
                                                    maximumFractionDigits: 2   // Limita a 2 casas decimais
                                        }).format(base_volume);

                                        let GateV = VolumeGate;  // Valor vindo da sua variável

                                            // Primeiro, substituímos a vírgula por um marcador temporário
                                            GateV = GateV.replace(/,/g, 'TEMP_COMMA');

                                            // Agora, substituímos o ponto por vírgula
                                            GateV = GateV.replace(/\./g, ',');
                                            GateV = GateV.replace(/TEMP_COMMA/g, '.');

                                        
                                        let VolumeMexc = new Intl.NumberFormat('en-US', {
                                                     style: 'currency',
                                                    currency: 'USD',  // Definindo a moeda como USD
                                                    minimumFractionDigits: 2,  // Exibe pelo menos 2 casas decimais
                                                    maximumFractionDigits: 2   // Limita a 2 casas decimais
                                        }).format(volume24);

                                            let MexcV = VolumeMexc
                                             // Primeiro, substituímos a vírgula por um marcador temporário
                                             MexcV = MexcV.replace(/,/g, 'TEMP_COMMA');

                                            // Agora, substituímos o ponto por vírgula
                                            MexcV = MexcV.replace(/\./g, ',');
                                            MexcV = MexcV.replace(/TEMP_COMMA/g, '.');
                                        
                                        if (profitGateioToMacx > 0) {
                                            let arbitrageClassGateioToMacx = profitGateioToMacx > 0 ? 'positive' : 'negative';
                                            let profitPercentage = (profitGateioToMacx / buyGateio) * 100;

                                            if (profitPercentage >= 0.3 && profitPercentage <= 20) {
                                                arbitrageResultsHTML += `
                                                    <div class="arbitrage-card">
                                                        <div class="arbitrage-header">${Pair}</div>
                                                        <div class="arbitrage-profit-percent ${arbitrageClassGateioToMacx}">
                                                            ${profitPercentage.toFixed(2)}%
                                                        </div>
                                                        <div class="arbitrage-body">
                                                            <p class="flex items-center space-x-1 text-center"><img class="w-7 h-7" src="{{ asset('gate.io.svg') }}"alt="MEXC Logo"><strong>Volume Gate.io:</strong> ${GateV}USDT</p>
                                                            <p class="flex items-center space-x-1 text-center"><img class="w-7 h-7" src="{{ asset('mexc-logo.svg') }}"alt="MEXC Logo"><strong>Volume Mecx:</strong> ${MexcV} USDT</p>
                                                            <p class="flex items-center space-x-1 text-center" id="finaciamento"><img class="w-7 h-7" src="{{ asset('mexc-logo.svg') }}" alt="MEXC Logo"> <strong>Taxa Financiamento:</strong> ${fundingRatpercentage.toFixed(2)}%</p>
                                                            <a href="javascript:void(0);" onclick="openTwoWindowsAndSaveData(
                                                                'https://www.gate.io/pt-br/trade/${gateioSymbol}', 
                                                                'https://futures.mexc.com/pt-PT/exchange/${gateioSymbol}', 
                                                                '${tickerGateio.currency_pair}', 
                                                                '${buyGateio}', 
                                                                '${sellMacx}', 
                                                                '${profitPercentage.toFixed(2)}', 
                                                                '${base_volume}', 
                                                                '${volume24}', 
                                                                '${fundingRatpercentage}'
                                                            )" class="button-link mt-auto bg-purple-500 text-white py-2 px-4 rounded-lg">Fazer Arbitragem</a>
                                                        </div>
                                                    </div>
                                                `;
                                            }
                                        }
                                    }
                                });

                                if (arbitrageResultsHTML) {
                                    $('#arbitrage-results').html(arbitrageResultsHTML);
                                } else {
                                    $('#arbitrage-results').html('<p>Nenhum lucro positivo encontrado entre 0,3% e 20%.</p>');
                                }
                            } else {
                                $('#error-message').html('Estrutura de dados da API Macx inesperada.');
                            }

                            $('#loading-message').hide(); // Oculta o carregando
                        },
                        error: function(xhr, status, error) {
                            $('#error-message').html('Erro ao carregar os dados da API Macx.');
                            $('#loading-message').hide();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    $('#error-message').html('Erro ao carregar os dados da API Gate.io.');
                    $('#loading-message').hide();
                }
            });
        }

        updateTickers();
        setInterval(updateTickers, 10000);
    </script>
@endsection
