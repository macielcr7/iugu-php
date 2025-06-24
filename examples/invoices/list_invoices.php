<?php

require __DIR__ . '/../bootstrap.php';

try {
    $invoices = $iugu->invoices()->list();
    print_r($invoices);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 