<?php

declare(strict_types=1);

namespace Iugu\Application\Bills;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Bills\Bill;

class CancelBillUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @return Bill
     * @throws \Exception
     */
    public function execute(string $id): Bill
    {
        $response = $this->client->put('boletos/' . $id . '/cancel');
        $body = json_decode((string) $response->getBody(), true);

        return new Bill(
            $body['id'] ?? null,
            $body['email'] ?? '',
            $body['due_date'] ?? null,
            $body['items'] ?? null,
            $body['status'] ?? null,
            $body['custom_variables'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
        );
    }
} 