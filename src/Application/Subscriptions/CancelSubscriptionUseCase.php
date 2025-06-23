<?php

declare(strict_types=1);

namespace Iugu\Application\Subscriptions;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Subscriptions\Subscription;

class CancelSubscriptionUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @return Subscription
     * @throws \Exception
     */
    public function execute(string $id): Subscription
    {
        $response = $this->client->put('subscriptions/' . $id . '/suspend');
        $body = json_decode((string) $response->getBody(), true);

        return new Subscription(
            $body['id'] ?? null,
            $body['customer_id'] ?? '',
            $body['plan_identifier'] ?? '',
            $body['status'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['custom_variables'] ?? null,
        );
    }
} 