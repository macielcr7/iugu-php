<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Splits\GetSplitUseCase;

$useCase = new GetSplitUseCase($client);

try {
    $split = $useCase->execute('ID_DO_SPLIT');
    print_r($split);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 