<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;

class CreatePaymentMethodUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $customerId
     * @param array $data
     * @return PaymentMethod
     * @throws \Exception
     */
    public function execute(string $customerId, array $data): PaymentMethod
    {
        $response = $this->client->post('customers/' . $customerId . '/payment_methods', $data);
        $body = json_decode((string) $response->getBody(), true);

        return new PaymentMethod(
            $body['id'] ?? null,
            $body['customer_id'] ?? $customerId,
            $body['description'] ?? $data['description'],
            $body['token'] ?? $data['token'],
            $body['item_type'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 