<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Subscriptions\ListSubscriptionsUseCase;

$useCase = new ListSubscriptionsUseCase($client);

try {
    $subscriptions = $useCase->execute();
    print_r($subscriptions);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 