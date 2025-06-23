<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;

class GetPaymentMethodUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $customerId
     * @param string $paymentMethodId
     * @return PaymentMethod
     * @throws \Exception
     */
    public function execute(string $customerId, string $paymentMethodId): PaymentMethod
    {
        $response = $this->client->get('customers/' . $customerId . '/payment_methods/' . $paymentMethodId);
        $body = json_decode((string) $response->getBody(), true);

        return new PaymentMethod(
            $body['id'] ?? null,
            $body['customer_id'] ?? $customerId,
            $body['description'] ?? '',
            $body['token'] ?? '',
            $body['item_type'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 