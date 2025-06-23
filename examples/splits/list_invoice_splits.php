<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Splits\ListInvoiceSplitsUseCase;

$useCase = new ListInvoiceSplitsUseCase($client);

try {
    $splits = $useCase->execute('ID_DA_FATURA');
    print_r($splits);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 