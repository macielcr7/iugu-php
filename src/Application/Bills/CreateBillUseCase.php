<?php

declare(strict_types=1);

namespace Iugu\Application\Bills;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Bills\Bill;

class CreateBillUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $data
     * @return Bill
     * @throws \Exception
     */
    public function execute(array $data): Bill
    {
        $response = $this->client->post('invoices', $data + ['recurrent' => true]);
        $body = json_decode((string) $response->getBody(), true);

        return new Bill(
            $body['id'] ?? null,
            $body['email'] ?? $data['email'],
            $body['due_date'] ?? $data['due_date'] ?? null,
            $body['items'] ?? $data['items'] ?? null,
            $body['status'] ?? null,
            $body['custom_variables'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
        );
    }
} 