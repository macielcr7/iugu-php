<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;

class ListWebhooksUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @return Webhook[]
     * @throws \Exception
     */
    public function execute(): array
    {
        $response = $this->client->get('triggers');
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $webhooks = [];
        foreach ($items as $item) {
            $webhooks[] = new Webhook(
                $item['id'] ?? null,
                $item['event'] ?? '',
                $item['url'] ?? '',
                $item['enabled'] ?? null,
                $item['created_at'] ?? null,
                $item['updated_at'] ?? null,
                $item['data'] ?? null,
            );
        }
        return $webhooks;
    }
} 