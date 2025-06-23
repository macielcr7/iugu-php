<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Subscriptions\CancelSubscriptionUseCase;

$useCase = new CancelSubscriptionUseCase($client);

try {
    $subscription = $useCase->execute('ID_DA_ASSINATURA');
    print_r($subscription);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 