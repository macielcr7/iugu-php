<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Application\Webhooks\Requests\UpdateWebhookRequest;
use Iugu\Domain\Webhooks\Webhook;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class UpdateWebhookUseCase
{
    private IuguHttpClient $iuguHttpClient;

    public function __construct(IuguHttpClient $iuguHttpClient)
    {
        $this->iuguHttpClient = $iuguHttpClient;
    }

    public function execute(string $id, UpdateWebhookRequest $request): Webhook
    {
        $response = $this->iuguHttpClient->put("/v1/webhooks/$id", $request->toArray());

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