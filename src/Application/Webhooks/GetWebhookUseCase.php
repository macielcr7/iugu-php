<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Domain\Webhooks\Webhook;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class GetWebhookUseCase
{
    private IuguHttpClient $iuguHttpClient;

    public function __construct(IuguHttpClient $iuguHttpClient)
    {
        $this->iuguHttpClient = $iuguHttpClient;
    }

    public function execute(string $id): Webhook
    {
        $response = $this->iuguHttpClient->get("/v1/webhooks/$id");

        $webhookData = json_decode($response->getBody()->getContents());

        return new Webhook(
            id: $webhookData->id,
            event: $webhookData->event,
            url: $webhookData->url,
            mode: $webhookData->mode,
            authorization: $webhookData->authorization ?? null,
        );
    }
} 