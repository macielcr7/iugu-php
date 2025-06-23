<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Webhooks\CreateWebhookUseCase;

$useCase = new CreateWebhookUseCase($client);

try {
    $webhook = $useCase->execute([
        'url' => 'https://meusite.com/webhook',
        'event' => 'invoice.created',
    ]);
    print_r($webhook);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 