<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Domain\Webhooks\Webhook;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class DeleteWebhookUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function execute(string $id): Webhook
    {
        $response = $this->client->delete("/v1/webhooks/$id");
        $body = json_decode($response->getBody()->getContents());

        return new Webhook(
            id: $body->id,
            event: $body->event,
            url: $body->url,
            mode: $body->mode,
            authorization: $body->authorization ?? null,
        );
    }
} 