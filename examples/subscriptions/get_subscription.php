<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Subscriptions\GetSubscriptionUseCase;

$useCase = new GetSubscriptionUseCase($client);

try {
    $subscription = $useCase->execute('ID_DA_ASSINATURA');
    print_r($subscription);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 