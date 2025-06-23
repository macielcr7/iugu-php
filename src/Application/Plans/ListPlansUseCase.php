<?php

declare(strict_types=1);

namespace Iugu\Application\Plans;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Plans\Plan;

class ListPlansUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @return Plan[]
     * @throws \Exception
     */
    public function execute(): array
    {
        $response = $this->client->get('plans');
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $plans = [];
        foreach ($items as $item) {
            $plans[] = new Plan(
                $item['id'] ?? null,
                $item['identifier'] ?? '',
                $item['name'] ?? '',
                $item['interval'] ?? null,
                $item['interval_type'] ?? null,
                $item['value_cents'] ?? null,
                $item['created_at'] ?? null,
                $item['updated_at'] ?? null,
                $item['features'] ?? null,
            );
        }
        return $plans;
    }
} 