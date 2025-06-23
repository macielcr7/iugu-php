<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Plans\GetPlanUseCase;

$useCase = new GetPlanUseCase($client);

try {
    $plan = $useCase->execute('ID_DO_PLANO');
    print_r($plan);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 