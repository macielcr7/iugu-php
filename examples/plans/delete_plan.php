<?php

require __DIR__ . '/../bootstrap.php';

try {
    $plan = $iugu->plans()->delete('ID_DO_PLANO');
    print_r($plan);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 