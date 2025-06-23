<?php

declare(strict_types=1);

namespace Iugu\Application\Customers;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Customers\Customer;

class ListCustomersUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $filters
     * @return Customer[]
     * @throws \Exception
     */
    public function execute(array $filters = []): array
    {
        $response = $this->client->get('customers', $filters);
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $customers = [];
        foreach ($items as $item) {
            $customers[] = new Customer(
                $item['id'] ?? null,
                $item['email'] ?? '',
                $item['name'] ?? null,
                $item['cpf_cnpj'] ?? null,
                $item['notes'] ?? null,
                $item['created_at'] ?? null,
                $item['updated_at'] ?? null,
                $item['custom_variables'] ?? null,
            );
        }
        return $customers;
    }
} 