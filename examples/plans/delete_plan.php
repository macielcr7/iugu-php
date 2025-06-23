<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Plans\DeletePlanUseCase;

$useCase = new DeletePlanUseCase($client);

try {
    $result = $useCase->execute('ID_DO_PLANO');
    print_r($result);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 