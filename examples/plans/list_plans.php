<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Plans\ListPlansUseCase;

$useCase = new ListPlansUseCase($client);

try {
    $plans = $useCase->execute();
    print_r($plans);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 