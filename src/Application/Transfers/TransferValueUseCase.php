<?php

declare(strict_types=1);

namespace Iugu\Application\Transfers;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Transfers\Transfer;

class TransferValueUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $data
     * @return Transfer
     * @throws \Exception
     */
    public function execute(array $data): Transfer
    {
        $response = $this->client->post('transfers', $data);
        $body = json_decode((string) $response->getBody(), true);

        return new Transfer(
            $body['id'] ?? null,
            $body['receiver_id'] ?? $data['receiver_id'],
            $body['amount'] ?? $data['amount'],
            $body['status'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 