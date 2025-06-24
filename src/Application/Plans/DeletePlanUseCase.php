<?php

declare(strict_types=1);

namespace Iugu\Application\Plans;

use Iugu\Domain\Plans\Feature;
use Iugu\Domain\Plans\Plan;
use Iugu\Domain\Plans\PlanPrice;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class DeletePlanUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function execute(string $id): Plan
    {
        $response = $this->client->delete("/v1/plans/$id");
        $body = json_decode($response->getBody()->getContents());

        $prices = [];
        if (!empty($body->prices)) {
            $prices = array_map(function ($price) {
                return new PlanPrice(
                    currency: $price->currency,
                    value_cents: $price->value_cents,
                );
            }, $body->prices);
        }

        $features = [];
        if (!empty($body->features)) {
            $features = array_map(function ($feature) {
                return new Feature(
                    name: $feature->name,
                    identifier: $feature->identifier,
                    value: $feature->value
                );
            }, $body->features);
        }

        return new Plan(
            id: $body->id,
            name: $body->name,
            identifier: $body->identifier,
            interval: $body->interval,
            interval_type: $body->interval_type,
            created_at: $body->created_at,
            updated_at: $body->updated_at,
            prices: $prices,
            features: $features,
            payable_with: $body->payable_with,
            max_cycles: $body->max_cycles,
        );
    }
}