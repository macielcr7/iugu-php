<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Invoices\ListInvoicesUseCase;

$useCase = new ListInvoicesUseCase($client);

try {
    $invoices = $useCase->execute();
    print_r($invoices);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 