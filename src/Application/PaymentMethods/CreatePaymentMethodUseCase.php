<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods;

use Iugu\Application\PaymentMethods\Requests\CreatePaymentMethodRequest;
use Iugu\Domain\PaymentMethods\PaymentMethod;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class CreatePaymentMethodUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $customer_id
     * @param CreatePaymentMethodRequest $request
     * @return PaymentMethod
     * @throws \Exception
     */
    public function execute(string $customer_id, CreatePaymentMethodRequest $request): PaymentMethod
    {
        $response = $this->client->post(
            "/v1/customers/{$customer_id}/payment_methods",
            $request
        );

        $body = json_decode($response->getBody()->getContents());

        return new PaymentMethod(
            id: $body->id ?? null,
            customer_id: $body->customer_id ?? $customer_id,
            description: $body->description ?? $request->description,
            token: $body->token ?? $request->token,
            item_type: $body->item_type ?? null,
            created_at: $body->created_at ?? null,
            updated_at: $body->updated_at ?? null,
            data: $body->data ?? null,
        );
    }
} 