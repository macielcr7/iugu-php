<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Splits\DeleteSplitUseCase;

$useCase = new DeleteSplitUseCase($client);

try {
    $result = $useCase->execute('ID_DO_SPLIT');
    print_r($result);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 