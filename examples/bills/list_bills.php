<?php

require __DIR__ . '/../bootstrap.php';

try {
    $bills = $iugu->bills()->list();
    print_r($bills);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 