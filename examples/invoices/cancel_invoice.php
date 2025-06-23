<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Invoices\CancelInvoiceUseCase;

$useCase = new CancelInvoiceUseCase($client);

try {
    $invoice = $useCase->execute('ID_DA_FATURA');
    print_r($invoice);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 