<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods;

use Iugu\Infrastructure\Http\IuguHttpClient;

class DeletePaymentMethodUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $customerId
     * @param string $paymentMethodId
     * @return bool
     * @throws \Exception
     */
    public function execute(string $customerId, string $paymentMethodId): bool
    {
        $response = $this->client->delete('customers/' . $customerId . '/payment_methods/' . $paymentMethodId);
        $body = json_decode((string) $response->getBody(), true);
        return ($body['success'] ?? false) === true;
    }
} 