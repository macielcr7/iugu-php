<?php

require __DIR__ . '/../bootstrap.php';

try {
    $customerId = 'ID_DO_CLIENTE';
    $paymentMethodId = 'ID_DA_FORMA';
    $paymentMethod = $iugu->paymentMethods()->get($customerId, $paymentMethodId);
    print_r($paymentMethod);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 