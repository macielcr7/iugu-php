<?php

require __DIR__ . '/../bootstrap.php';

try {
    $invoiceId = 'ID_DA_FATURA';
    $splits = $iugu->splits()->listFromInvoice($invoiceId);
    print_r($splits);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 