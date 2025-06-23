<?php

declare(strict_types=1);

namespace Iugu\Application\Subscriptions;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Subscriptions\Subscription;

class CreateSubscriptionUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $data
     * @return Subscription
     * @throws \Exception
     */
    public function execute(array $data): Subscription
    {
        $response = $this->client->post('subscriptions', $data);
        $body = json_decode((string) $response->getBody(), true);

        return new Subscription(
            $body['id'] ?? null,
            $body['customer_id'] ?? $data['customer_id'],
            $body['plan_identifier'] ?? $data['plan_identifier'],
            $body['status'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['custom_variables'] ?? null,
        );
    }
} 