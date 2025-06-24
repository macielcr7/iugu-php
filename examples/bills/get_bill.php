<?php

require __DIR__ . '/../bootstrap.php';

try {
    $bill = $iugu->bills()->get('ID_DO_CARNE');
    print_r($bill);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 