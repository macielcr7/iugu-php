<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Webhooks\GetWebhookUseCase;

$useCase = new GetWebhookUseCase($client);

try {
    $webhook = $useCase->execute('ID_DO_WEBHOOK');
    print_r($webhook);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 