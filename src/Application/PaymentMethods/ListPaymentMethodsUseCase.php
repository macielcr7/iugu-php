<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;

class ListPaymentMethodsUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $customerId
     * @return PaymentMethod[]
     * @throws \Exception
     */
    public function execute(string $customerId): array
    {
        $response = $this->client->get('customers/' . $customerId . '/payment_methods');
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $methods = [];
        foreach ($items as $item) {
            $methods[] = new PaymentMethod(
                $item['id'] ?? null,
                $item['customer_id'] ?? $customerId,
                $item['description'] ?? '',
                $item['token'] ?? '',
                $item['item_type'] ?? null,
                $item['created_at'] ?? null,
                $item['updated_at'] ?? null,
                $item['data'] ?? null,
            );
        }
        return $methods;
    }
} 