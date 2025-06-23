<?php

declare(strict_types=1);

namespace Iugu\Application\Transfers;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Transfers\Transfer;

class GetTransferUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @return Transfer
     * @throws \Exception
     */
    public function execute(string $id): Transfer
    {
        $response = $this->client->get('transfers/' . $id);
        $body = json_decode((string) $response->getBody(), true);

        return new Transfer(
            $body['id'] ?? null,
            $body['receiver_id'] ?? '',
            $body['amount'] ?? 0,
            $body['status'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 