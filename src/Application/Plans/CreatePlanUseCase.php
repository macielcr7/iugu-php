<?php

declare(strict_types=1);

namespace Iugu\Application\Plans;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Plans\Plan;

class CreatePlanUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $data
     * @return Plan
     * @throws \Exception
     */
    public function execute(array $data): Plan
    {
        $response = $this->client->post('plans', $data);
        $body = json_decode((string) $response->getBody(), true);

        return new Plan(
            $body['id'] ?? null,
            $body['identifier'] ?? $data['identifier'],
            $body['name'] ?? $data['name'],
            $body['interval'] ?? $data['interval'] ?? null,
            $body['interval_type'] ?? $data['interval_type'] ?? null,
            $body['value_cents'] ?? $data['value_cents'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['features'] ?? null,
        );
    }
} 