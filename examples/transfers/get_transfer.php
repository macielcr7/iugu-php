<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Transfers\GetTransferUseCase;

$useCase = new GetTransferUseCase($client);

try {
    $transfer = $useCase->execute('ID_DA_TRANSFERENCIA');
    print_r($transfer);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 