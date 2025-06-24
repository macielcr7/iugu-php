<?php

require __DIR__ . '/../bootstrap.php';

try {
    $subscription = $iugu->subscriptions()->get('ID_DA_ASSINATURA');
    print_r($subscription);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 