<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Application\Webhooks\Requests\CreateWebhookRequest;
use Iugu\Domain\Webhooks\Webhook;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class CreateWebhookUseCase
{
    private IuguHttpClient $iuguHttpClient;

    public function __construct(IuguHttpClient $iuguHttpClient)
    {
        $this->iuguHttpClient = $iuguHttpClient;
    }

    public function execute(CreateWebhookRequest $request): Webhook
    {
        $response = $this->iuguHttpClient->post('/v1/webhooks', $request->toArray());

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