<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Plans\CreatePlanUseCase;

$useCase = new CreatePlanUseCase($client);

try {
    $plan = $useCase->execute([
        'name' => 'Plano Exemplo',
        'identifier' => 'plano_exemplo',
        'interval' => 1,
        'interval_type' => 'months',
        'value_cents' => 1000,
    ]);
    print_r($plan);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 