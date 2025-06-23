<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Webhooks\ListWebhooksUseCase;

$useCase = new ListWebhooksUseCase($client);

try {
    $webhooks = $useCase->execute();
    print_r($webhooks);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 