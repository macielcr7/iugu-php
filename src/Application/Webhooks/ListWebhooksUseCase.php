<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Domain\Webhooks\Webhook;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class ListWebhooksUseCase
{
    private IuguHttpClient $iuguHttpClient;

    public function __construct(IuguHttpClient $iuguHttpClient)
    {
        $this->iuguHttpClient = $iuguHttpClient;
    }

    /**
     * @return Webhook[]
     */
    public function execute(): array
    {
        $response = $this->iuguHttpClient->get('/v1/webhooks');

        $webhooksData = json_decode($response->getBody()->getContents());

        return array_map(function ($webhookData) {
            return new Webhook(
                id: $webhookData->id,
                event: $webhookData->event,
                url: $webhookData->url,
                mode: $webhookData->mode,
                authorization: $webhookData->authorization ?? null,
            );
        }, $webhooksData->items);
    }
} 