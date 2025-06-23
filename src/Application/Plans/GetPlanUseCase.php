<?php

declare(strict_types=1);

namespace Iugu\Application\Plans;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Plans\Plan;

class GetPlanUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @return Plan
     * @throws \Exception
     */
    public function execute(string $id): Plan
    {
        $response = $this->client->get('plans/' . $id);
        $body = json_decode((string) $response->getBody(), true);

        return new Plan(
            $body['id'] ?? null,
            $body['identifier'] ?? '',
            $body['name'] ?? '',
            $body['interval'] ?? null,
            $body['interval_type'] ?? null,
            $body['value_cents'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['features'] ?? null,
        );
    }
} 