<?php

use Iugu\Application\Webhooks\Requests\CreateWebhookRequest;

require_once __DIR__ . '/../bootstrap.php';

$webhook = $iugu->webhooks()->create(
    new CreateWebhookRequest(
        event: 'invoice.created',
        url: 'https://iugu-php-example.com/webhooks'
    )
);

print_r($webhook);