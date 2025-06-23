<?php

declare(strict_types=1);

namespace Iugu\Application\Customers;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Customers\Customer;

class CreateCustomerUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $data
     * @return Customer
     * @throws \Exception
     */
    public function execute(array $data): Customer
    {
        $response = $this->client->post('customers', $data);
        $body = json_decode((string) $response->getBody(), true);

        return new Customer(
            $body['id'] ?? null,
            $body['email'] ?? $data['email'],
            $body['name'] ?? $data['name'] ?? null,
            $body['cpf_cnpj'] ?? $data['cpf_cnpj'] ?? null,
            $body['notes'] ?? $data['notes'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['custom_variables'] ?? null,
        );
    }
} 