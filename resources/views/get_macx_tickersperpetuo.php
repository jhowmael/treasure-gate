<?php
// URL da API do Gate.io para obter os tickers de mercado
$url = "https://contract.mexc.com/api/v1/contract/ticker";

// Iniciar a requisição cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executar a requisição e pegar a resposta
$response = curl_exec($ch);

// Fechar a conexão cURL
curl_close($ch);

// Verificar se houve algum erro na requisição
if ($response === false) {
    $error_message = "Erro ao fazer a requisição!";
    $data2 = [];
} else {
    // Converter o JSON para um array associativo
    $data2 = json_decode($response, true);
}

// Verificar se a conversão foi bem-sucedida
if ($data2 === null) {
    $error_message = "Erro ao decodificar os dados JSON!";
} else {
    $error_message = "";
}

// Retornar os dados como JSON
echo json_encode($data2);
?>
