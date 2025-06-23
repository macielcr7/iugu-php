<?php

declare(strict_types=1);

namespace Iugu\Application\Customers;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Customers\Customer;

class GetCustomerUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @return Customer
     * @throws \Exception
     */
    public function execute(string $id): Customer
    {
        $response = $this->client->get('customers/' . $id);
        $body = json_decode((string) $response->getBody(), true);

        return new Customer(
            $body['id'] ?? null,
            $body['email'] ?? '',
            $body['name'] ?? null,
            $body['cpf_cnpj'] ?? null,
            $body['notes'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['custom_variables'] ?? null,
        );
    }
} 