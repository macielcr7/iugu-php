<?php

declare(strict_types=1);

namespace Iugu\Application\Subscriptions;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Subscriptions\Subscription;

class ListSubscriptionsUseCase
{
    public function __construct(private IuguHttpClient $client)
    {
    }

    /**
     * @param array $filters
     * @return Subscription[]
     * @throws \Exception
     */
    public function execute(array $filters = []): array
    {
        $response = $this->client->get('/v1/subscriptions', $filters);
        $body = json_decode($response->getBody()->getContents());
        $items = $body->items ?? [];
        $subscriptions = [];
        foreach ($items as $item) {
            $subscriptions[] = new Subscription(
                id: $item->id ?? null,
                suspended: $item->suspended ?? null,
                plan_identifier: $item->plan_identifier ?? null,
                customer_id: $item->customer_id ?? null,
                expires_at: $item->expires_at ?? null,
                created_at: $item->created_at ?? null,
                updated_at: $item->updated_at ?? null,
                cycles_count: $item->cycles_count ?? null,
                active: $item->active ?? null,
                custom_variables: $item->custom_variables ?? null,
                subitems: $item->subitems ?? null,
            );
        }
        return $subscriptions;
    }
} 