<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;

class GetWebhookUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @return Webhook
     * @throws \Exception
     */
    public function execute(string $id): Webhook
    {
        $response = $this->client->get('triggers/' . $id);
        $body = json_decode((string) $response->getBody(), true);

        return new Webhook(
            $body['id'] ?? null,
            $body['event'] ?? '',
            $body['url'] ?? '',
            $body['enabled'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 