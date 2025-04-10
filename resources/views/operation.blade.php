@extends('layouts.web')


@section('content')
    <div class="arbitrage-card" style="width: 350px; padding: 15px;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <p class="font-bold text-gray-50"><span id="currencyPairText"></span></p>
        <span class="dot items-center" id="statusDot"></span>
        </div>
        <div class="card-body">

            <!-- Formulário compactado para atualização dos preços -->
            <form id="updatePricesForm">
                <div class="form-group">
                    <label class="flex items-center mb-2 mt-2 space-x-2 text-center" for="buyPriceEntry"><img class="w-7 mr-1 h-7" src="{{ asset('gate.io.svg') }}"alt="MEXC Logo">Compra (Entrada) Gate.io:</label>
                    <input type="number" id="buyPriceEntry" class="form-control w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" step="any" style="font-size: 14px;">
                </div>
                <div class="form-group">
                    <label class="flex items-center mb-2 mt-2 space-x-2 text-center" for="sellPriceEntry"><img class="w-7 mr-1 h-7" src="{{ asset('mexc-logo.svg') }}"alt="MEXC Logo">Venda (Entrada) MEXC:</label>
                    <input type="number" id="sellPriceEntry" class="form-control form-control w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" step="any" style="font-size: 14px;" step="any" style="font-size: 14px;">
                </div>
                <button type="submit" class="button-link btn btn-primary mt-5 bg-purple-500 text-white py-2 px-6 rounded-lg" style="font-size: 14px;">Atualizar</button>
            </form>

            <div class="price-info mt-3">
                <div class="row">
                    <div class="col-6">
                        <p><strong>Compra (Gate.io):</strong> <span id="buyPriceEntryGateio"></span></p>
                    </div>
                    <div class="col-6">
                        <p><strong>Venda (MEXC):</strong> <span id="sellPriceEntryMacx"></span></p>
                    </div>
                </div>
            </div>

            <div class="price-info mt-3">
                <div class="row">
                    <div class="col-6">
                        <p><strong>Compra Atual MEXC:</strong> <span id="buyPriceCurrentMacx"></span></p>
                    </div>
                    <div class="col-6">
                        <p><strong>Venda Atual Gate.io:</strong> <span id="sellPriceCurrentGateio"></span></p>
                    </div>
                </div>
            </div>

            <div class="profit-info mt-3">
                <p id="entryProfit"></p>
                <p id="exitProfit"></p>
                <p id="arbitrageResult"></p>
            </div>
            
            <button id="endOperationButton" class="button-link btn btn-primary mt-2 bg-indigo-500 text-white py-2 px-4 rounded-lg">Encerrar Operação</button>
        </div>
    </div>

    <div id="loading-message" class="loading"></div>
    <div id="error-message" class="error"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.onload = function() {
            const clickedCurrencyPair = sessionStorage.getItem('clickedCurrencyPair');
            const buyPriceEntry = sessionStorage.getItem('buyPrice');
            const sellPriceEntry = sessionStorage.getItem('sellPrice');

            if (clickedCurrencyPair) {
                document.getElementById('currencyPairText').textContent = clickedCurrencyPair;
                document.getElementById('buyPriceEntryGateio').textContent = buyPriceEntry;
                document.getElementById('sellPriceEntryMacx').textContent = sellPriceEntry;
                updateTickers(clickedCurrencyPair, buyPriceEntry, sellPriceEntry);
            } else {
                document.getElementById('currencyPairText').textContent = 'Nenhum par de moedas selecionado';
            }

            if (buyPriceEntry) {
                document.getElementById('buyPriceEntry').value = buyPriceEntry;
            }
            if (sellPriceEntry) {
                document.getElementById('sellPriceEntry').value = sellPriceEntry;
            }

            document.getElementById('updatePricesForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Previne o envio do formulário

                const updatedBuyPrice = parseFloat(document.getElementById('buyPriceEntry').value);
                const updatedSellPrice = parseFloat(document.getElementById('sellPriceEntry').value);

                // Verifica se ambos os valores são válidos
                if (!isNaN(updatedBuyPrice) && !isNaN(updatedSellPrice)) {
                    // Atualiza os preços nas variáveis de sessão
                    sessionStorage.setItem('buyPrice', updatedBuyPrice);
                    sessionStorage.setItem('sellPrice', updatedSellPrice);

                    // Exibe os valores atualizados na interface
                    document.getElementById('buyPriceEntryGateio').textContent = updatedBuyPrice.toFixed(4);
                    document.getElementById('sellPriceEntryMacx').textContent = updatedSellPrice.toFixed(4);

                    // Exibe uma mensagem de sucesso
                    showAlert('Preços atualizados com sucesso!','success');

                    // Chama a função para atualizar os dados de preços
                    updateTickers(clickedCurrencyPair, updatedBuyPrice, updatedSellPrice);
                } else {
                    // Alerta caso os valores não sejam válidos
                    showAlert('Por favor, insira ambos os preços de compra e venda válidos.','error');
                }
            });

            document.getElementById('endOperationButton').addEventListener('click', function() {
                storeOperationData(buyPriceEntry, sellPriceEntry);
                endOperation(); // Chama a função para encerrar a operação
            });
        };

       async function updateTickers(currencyPair, buyPriceEntry, sellPriceEntry) {
            $('#loading-message').show();

            try {
                // Fetch Gate.io data
                const responseGateio = await fetch('{{ url("/get_gateio_tickers") }}');
                const dataGateio = await responseGateio.json();

                // Fetch MEXC data
                const responseMacx = await fetch('{{ url("/get_macx_tickersperpetuo") }}');
                const dataMacx = await responseMacx.json();

                if (dataMacx && dataMacx.data) {
                    let macxData = {};
                    dataMacx.data.forEach(ticker => {
                        macxData[ticker.symbol.trim().toUpperCase()] = ticker;
                    });

                    // Process Gate.io and MEXC data
                    dataGateio.forEach(tickerGateio => {
                        let gateioSymbol = tickerGateio.currency_pair.trim().toUpperCase();
                        if (gateioSymbol === currencyPair) {
                            let sellGateio = tickerGateio.highest_bid;
                            let buyMacx = macxData[gateioSymbol] ? macxData[gateioSymbol].ask1 : null;

                            if (buyMacx) {
                                document.getElementById('buyPriceCurrentMacx').textContent = buyMacx;
                                document.getElementById('sellPriceCurrentGateio').textContent = sellGateio;

                                let arbitrageProfitEntrada = (sellPriceEntry - buyPriceEntry).toFixed(4);
                                let arbitrageProfitSaida = (buyMacx - sellGateio).toFixed(4);
                                let profitPercentageEntrada = ((arbitrageProfitEntrada / buyPriceEntry) * 100).toFixed(2);
                                let profitPercentageSaida = ((arbitrageProfitSaida / sellGateio) * 100).toFixed(2);
                                let profitFinal = (parseFloat(profitPercentageEntrada) - parseFloat(profitPercentageSaida)).toFixed(2);

                                document.getElementById('entryProfit').textContent = `Entrada: ${profitPercentageEntrada}%`;
                                document.getElementById('exitProfit').textContent = `Saída: ${profitPercentageSaida}%`;

                                let finalResult = `Lucro Final: ${profitFinal}%`;
                                document.getElementById('arbitrageResult').textContent = finalResult;

                                // Muda a cor do texto e o fundo conforme o lucro
                                let arbitrageResultElement = document.getElementById('arbitrageResult');
                                if (profitFinal > 0) {
                                    arbitrageResultElement.style.color = 'green';
                                    
                                } else {
                                    arbitrageResultElement.style.color = 'red';
                                    
                                }

                                // Coloriza conforme o lucro e faz o ponto piscar
                                let statusDot = document.getElementById('statusDot');
                                if (profitFinal > 0) {
                                    statusDot.style.animation = 'blinkingGreen 1s infinite';
                                    statusDot.style.backgroundColor = 'green';
                                } else {
                                    statusDot.style.animation = 'blinkingRed 1s infinite';
                                    statusDot.style.backgroundColor = 'red';
                                }
                            }
                        }
                    });
                } else {
                    $('#error-message').html('Estrutura de dados da API Macx inesperada.');
                }
            } catch (error) {
                $('#error-message').html('Erro ao carregar os dados das APIs.');
            } finally {
                $('#loading-message').hide();
            }
        }

        function storeOperationData(buyPriceEntry, sellPriceEntry) {
            const currentProfit = parseFloat(document.getElementById('arbitrageResult').textContent.replace('Lucro Final: ', '').replace('%', ''));
            const entryProfit = parseFloat(document.getElementById('entryProfit').textContent.replace('Entrada: ', '').replace('%', ''));
            const exitProfit = parseFloat(document.getElementById('exitProfit').textContent.replace('Saída: ', '').replace('%', ''));

            const operation = {
                bancaInicial: buyPriceEntry,
                lucroFinal: currentProfit,
                entryProfit: entryProfit,
                exitProfit: exitProfit
            };

            let operations = JSON.parse(localStorage.getItem('operations')) || [];
            operations.push(operation);
            localStorage.setItem('operations', JSON.stringify(operations));
        }

        function endOperation() {
            // Esconde o card da página
            document.querySelector('.arbitrage-card').style.display = 'none';

            showAlert('Operação encerrada. Aguardando nova arbitragem...','success');

            // Limpa os valores do formulário e dos resultados
            document.getElementById('buyPriceEntry').value = '';
            document.getElementById('sellPriceEntry').value = '';
            document.getElementById('buyPriceCurrentMacx').textContent = '';
            document.getElementById('sellPriceCurrentGateio').textContent = '';
            document.getElementById('entryProfit').textContent = '';
            document.getElementById('exitProfit').textContent = '';
            document.getElementById('arbitrageResult').textContent = '';
        }

        // Inicializa a primeira chamada de updateTickers com os valores do sessionStorage
        setInterval(() => {
            const clickedCurrencyPair = sessionStorage.getItem('clickedCurrencyPair');
            const buyPriceEntry = parseFloat(sessionStorage.getItem('buyPrice'));
            const sellPriceEntry = parseFloat(sessionStorage.getItem('sellPrice'));

            if (clickedCurrencyPair) {
                updateTickers(clickedCurrencyPair, buyPriceEntry, sellPriceEntry);
            }
        }, 10000); // Atualização a cada 10 segundos
    </script>

<div id="customAlert" class="hidden fixed top-4 right-4 z-50 w-full max-w-sm bg-green-500 text-white rounded-lg shadow-lg p-4 flex items-start gap-3 animate-fade-in">
    
    <p id="alertMessage" class="text-sm font-medium leading-snug">Mensagem de sucesso aqui!</p>
</div>

    <style>
        /* Adicionando animações de piscamento para o ponto */
        @keyframes blinkingGreen {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes blinkingRed {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }

        .dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: gray;
        }

        @keyframes fadeIn {
    from { opacity: 0; transform: translateY(0.5rem); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
    </style>
@endsection
