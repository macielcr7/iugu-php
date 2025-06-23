<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\DirectCharges\ChargeTwoCreditCardsUseCase;

$useCase = new ChargeTwoCreditCardsUseCase($client);

try {
    $result = $useCase->execute([
        'api_token' => 'SEU_API_TOKEN',
        'invoiced_id' => 'ID_DA_FATURA',
        'iugu_credit_card_payment' => [
            ['token' => 'TOKEN_CARTAO_1', 'amount' => 500],
            ['token' => 'TOKEN_CARTAO_2', 'amount' => 500],
        ],
    ]);
    print_r($result);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 