<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Invoices\GetInvoiceUseCase;

$useCase = new GetInvoiceUseCase($client);

try {
    $invoice = $useCase->execute('ID_DA_FATURA');
    print_r($invoice);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 