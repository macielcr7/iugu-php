<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;

class UpdatePaymentMethodUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $customerId
     * @param string $paymentMethodId
     * @param array $data
     * @return PaymentMethod
     * @throws \Exception
     */
    public function execute(string $customerId, string $paymentMethodId, array $data): PaymentMethod
    {
        $response = $this->client->put('customers/' . $customerId . '/payment_methods/' . $paymentMethodId, $data);
        $body = json_decode((string) $response->getBody(), true);

        return new PaymentMethod(
            $body['id'] ?? null,
            $body['customer_id'] ?? $customerId,
            $body['description'] ?? $data['description'] ?? '',
            $body['token'] ?? $data['token'] ?? '',
            $body['item_type'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 