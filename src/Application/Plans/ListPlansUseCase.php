<?php

declare(strict_types=1);

namespace Iugu\Application\Plans;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Plans\Plan;

final class ListPlansUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return Plan[]
     */
    public function execute(): array
    {
        $response = $this->client->get('/v1/plans');
        $body = json_decode($response->getBody()->getContents());

        return array_map(function ($item) {
            return new Plan(
                id: $item->id ?? null,
                identifier: $item->identifier ?? '',
                name: $item->name ?? '',
                interval: $item->interval ?? null,
                interval_type: $item->interval_type ?? null,
                created_at: $item->created_at ?? null,
                updated_at: $item->updated_at ?? null,
                features: $item->features ?? null,
                prices: $item->prices ?? null,
                payable_with: $item->payable_with ?? null,
                max_cycles: $item->max_cycles ?? null,
            );
        }, $body->items);
    }
} 