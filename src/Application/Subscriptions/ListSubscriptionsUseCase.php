<?php

declare(strict_types=1);

namespace Iugu\Application\Subscriptions;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Subscriptions\Subscription;

class ListSubscriptionsUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $filters
     * @return Subscription[]
     * @throws \Exception
     */
    public function execute(array $filters = []): array
    {
        $response = $this->client->get('subscriptions', $filters);
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $subscriptions = [];
        foreach ($items as $item) {
            $subscriptions[] = new Subscription(
                $item['id'] ?? null,
                $item['customer_id'] ?? '',
                $item['plan_identifier'] ?? '',
                $item['status'] ?? null,
                $item['created_at'] ?? null,
                $item['updated_at'] ?? null,
                $item['custom_variables'] ?? null,
            );
        }
        return $subscriptions;
    }
} 