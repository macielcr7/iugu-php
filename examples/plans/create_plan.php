<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Plans\CreatePlanUseCase;
use Iugu\Application\Plans\Requests\CreatePlanRequest;
use Iugu\Application\Plans\Requests\FeatureRequest;
use Iugu\Application\Plans\Requests\PlanPriceRequest;

$useCase = new CreatePlanUseCase($client);

try {
    $prices = [
        new PlanPriceRequest(currency: 'BRL', value_cents: 5000)
    ];

    $features = [
        new FeatureRequest(name: 'Recurso 1', value: 10),
        new FeatureRequest(name: 'Recurso 2', value: 20),
    ];

    $planRequest = new CreatePlanRequest(
        name: 'Plano Exemplo Novo',
        identifier: 'plano_exemplo_novo_' . time(),
        interval: 1,
        interval_type: 'months',
        prices: $prices,
        features: $features
    );
    $plan = $useCase->execute($planRequest);
    print_r($plan);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 