<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Transfers\ListTransfersUseCase;

$useCase = new ListTransfersUseCase($client);

try {
    $transfers = $useCase->execute();
    print_r($transfers);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 