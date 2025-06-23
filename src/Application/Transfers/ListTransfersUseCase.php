<?php

declare(strict_types=1);

namespace Iugu\Application\Transfers;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Transfers\Transfer;

class ListTransfersUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @return Transfer[]
     * @throws \Exception
     */
    public function execute(): array
    {
        $response = $this->client->get('transfers');
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $transfers = [];
        foreach ($items as $item) {
            $transfers[] = new Transfer(
                $item['id'] ?? null,
                $item['receiver_id'] ?? '',
                $item['amount'] ?? 0,
                $item['status'] ?? null,
                $item['created_at'] ?? null,
                $item['updated_at'] ?? null,
                $item['data'] ?? null,
            );
        }
        return $transfers;
    }
} 