<?php

require __DIR__ . '/../bootstrap.php';

try {
    $invoice = $iugu->invoices()->cancel('ID_DA_FATURA');
    print_r($invoice);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 