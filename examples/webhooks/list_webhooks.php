<?php

require __DIR__ . '/../bootstrap.php';

try {
    $webhooks = $iugu->webhooks()->list();
    print_r($webhooks);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 