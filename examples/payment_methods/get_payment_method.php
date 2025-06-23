<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\PaymentMethods\GetPaymentMethodUseCase;

$useCase = new GetPaymentMethodUseCase($client);

try {
    $paymentMethod = $useCase->execute('ID_DO_CLIENTE', 'ID_DA_FORMA_PAGAMENTO');
    print_r($paymentMethod);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 