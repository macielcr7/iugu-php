<?php

require __DIR__ . '/../bootstrap.php';

try {
    $customer = $iugu->customers()->delete('ID_DO_CLIENTE');
    print_r($customer);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 