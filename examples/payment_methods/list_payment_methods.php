<?php

require __DIR__ . '/../bootstrap.php';

try {
    $customerId = 'ID_DO_CLIENTE';
    $paymentMethods = $iugu->paymentMethods()->list($customerId);
    print_r($paymentMethods);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 