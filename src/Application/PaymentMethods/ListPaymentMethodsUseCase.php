<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;

final class ListPaymentMethodsUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return PaymentMethod[]
     */
    public function execute(string $customer_id): array
    {
        $response = $this->client->get("/v1/customers/{$customer_id}/payment_methods");
        $body = json_decode($response->getBody()->getContents());

        return array_map(function ($item) use ($customer_id) {
            return new PaymentMethod(
                id: $item->id ?? null,
                customer_id: $item->customer_id ?? $customer_id,
                description: $item->description ?? '',
                token: $item->token ?? '',
                item_type: $item->item_type ?? null,
                created_at: $item->created_at ?? null,
                updated_at: $item->updated_at ?? null,
                data: $item->data ?? null,
            );
        }, $body->items);
    }
} 