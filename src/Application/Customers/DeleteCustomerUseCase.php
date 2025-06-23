<?php

declare(strict_types=1);

namespace Iugu\Application\Customers;

use Iugu\Infrastructure\Http\IuguHttpClient;

class DeleteCustomerUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public function execute(string $id): bool
    {
        $response = $this->client->delete('customers/' . $id);
        $body = json_decode((string) $response->getBody(), true);
        return ($body['success'] ?? false) === true;
    }
} 