<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\PaymentMethods\CreatePaymentMethodUseCase;

$useCase = new CreatePaymentMethodUseCase($client);

try {
    $paymentMethod = $useCase->execute('ID_DO_CLIENTE', [
        'description' => 'Meu Cartão',
        'token' => 'TOKEN_DE_PAGAMENTO',
        'set_as_default' => true,
    ]);
    print_r($paymentMethod);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 