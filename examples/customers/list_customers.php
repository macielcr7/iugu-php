<?php

require __DIR__ . '/../bootstrap.php';

try {
    $customers = $iugu->customers()->list();
    print_r($customers);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 