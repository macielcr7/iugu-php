<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\PaymentMethods\ListPaymentMethodsUseCase;

$useCase = new ListPaymentMethodsUseCase($client);

try {
    $paymentMethods = $useCase->execute('ID_DO_CLIENTE');
    print_r($paymentMethods);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 