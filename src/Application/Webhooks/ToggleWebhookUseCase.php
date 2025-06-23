<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;

class ToggleWebhookUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @param bool $enabled
     * @return Webhook
     * @throws \Exception
     */
    public function execute(string $id, bool $enabled): Webhook
    {
        $response = $this->client->put('triggers/' . $id . '/toggle', ['enabled' => $enabled]);
        $body = json_decode((string) $response->getBody(), true);

        return new Webhook(
            $body['id'] ?? null,
            $body['event'] ?? '',
            $body['url'] ?? '',
            $body['enabled'] ?? $enabled,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 