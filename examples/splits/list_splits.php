<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Splits\ListSplitsUseCase;

$useCase = new ListSplitsUseCase($client);

try {
    $splits = $useCase->execute();
    print_r($splits);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 