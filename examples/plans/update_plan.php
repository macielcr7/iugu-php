<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Plans\UpdatePlanUseCase;
use Iugu\Application\Plans\Requests\UpdatePlanRequest;

$useCase = new UpdatePlanUseCase($client);

try {
    // Substitua 'PLAN_ID_HERE' pelo ID real do plano que você deseja atualizar
    $planId = 'PLAN_ID_HERE';

    $planRequest = new UpdatePlanRequest(
        name: 'Plano Exemplo Atualizado'
    );
    
    $plan = $useCase->execute($planId, $planRequest);
    print_r($plan);
    
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 