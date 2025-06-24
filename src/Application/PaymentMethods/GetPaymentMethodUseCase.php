<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;

final class GetPaymentMethodUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $customer_id
     * @param string $payment_method_id
     * @return PaymentMethod
     * @throws \Exception
     */
    public function execute(string $customer_id, string $payment_method_id): PaymentMethod
    {
        $response = $this->client->get("/v1/customers/{$customer_id}/payment_methods/{$payment_method_id}");
        $body = json_decode($response->getBody()->getContents());

        return new PaymentMethod(
            id: $body->id ?? null,
            customer_id: $body->customer_id ?? $customer_id,
            description: $body->description ?? '',
            token: $body->token ?? '',
            item_type: $body->item_type ?? null,
            created_at: $body->created_at ?? null,
            updated_at: $body->updated_at ?? null,
            data: $body->data ?? null,
        );
    }
} 