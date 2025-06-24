<?php

declare(strict_types=1);

namespace Iugu\Application\Plans;

use Iugu\Application\Plans\Requests\CreatePlanRequest;
use Iugu\Domain\Plans\Feature;
use Iugu\Domain\Plans\Plan;
use Iugu\Domain\Plans\PlanPrice;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class CreatePlanUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param CreatePlanRequest $request
     * @return Plan
     * @throws \Exception
     */
    public function execute(CreatePlanRequest $request): Plan
    {
        $response = $this->client->post('/v1/plans', $request);
        $body = json_decode($response->getBody()->getContents());

        $features = null;
        if (!empty($body->features)) {
            $features = array_map(
                fn ($feature) => new Feature(
                    name: $feature->name,
                    identifier: $feature->identifier,
                    value: $feature->value
                ),
                $body->features
            );
        }

        $prices = null;
        if (!empty($body->prices)) {
            $prices = array_map(
                fn ($price) => new PlanPrice(
                    id: $price->id,
                    currency: $price->currency,
                    value_cents: $price->value_cents
                ),
                $body->prices
            );
        }

        return new Plan(
            id: $body->id ?? null,
            identifier: $body->identifier ?? $request->identifier,
            name: $body->name ?? $request->name,
            interval: $body->interval ?? $request->interval,
            interval_type: $body->interval_type ?? $request->interval_type,
            created_at: $body->created_at ?? null,
            updated_at: $body->updated_at ?? null,
            features: $features,
            prices: $prices
        );
    }
} 