<?php

require __DIR__ . '/../bootstrap.php';

try {
    $plans = $iugu->plans()->list();
    print_r($plans);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 