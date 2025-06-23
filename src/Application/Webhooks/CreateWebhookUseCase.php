<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;

class CreateWebhookUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $data
     * @return Webhook
     * @throws \Exception
     */
    public function execute(array $data): Webhook
    {
        $response = $this->client->post('triggers', $data);
        $body = json_decode((string) $response->getBody(), true);

        return new Webhook(
            $body['id'] ?? null,
            $body['event'] ?? $data['event'],
            $body['url'] ?? $data['url'],
            $body['enabled'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 