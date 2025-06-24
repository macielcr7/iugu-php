<?php

require __DIR__ . '/../bootstrap.php';

try {
    $split = $iugu->splits()->delete('ID_DO_SPLIT');
    print_r($split);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 