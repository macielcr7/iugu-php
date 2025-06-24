<?php

require __DIR__ . '/../bootstrap.php';

try {
    $subscriptions = $iugu->subscriptions()->list();
    print_r($subscriptions);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 