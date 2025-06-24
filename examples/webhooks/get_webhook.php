<?php

require __DIR__ . '/../bootstrap.php';

try {
    $webhook = $iugu->webhooks()->get('ID_DO_WEBHOOK');
    print_r($webhook);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 