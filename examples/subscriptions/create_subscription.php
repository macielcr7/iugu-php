<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Subscriptions\CreateSubscriptionUseCase;

$useCase = new CreateSubscriptionUseCase($client);

try {
    $subscription = $useCase->execute([
        'customer_id' => 'ID_DO_CLIENTE',
        'plan_identifier' => 'IDENTIFICADOR_DO_PLANO',
    ]);
    print_r($subscription);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 