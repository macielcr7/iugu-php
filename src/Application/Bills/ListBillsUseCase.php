<?php

declare(strict_types=1);

namespace Iugu\Application\Bills;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Bills\Bill;

class ListBillsUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $filters
     * @return Bill[]
     * @throws \Exception
     */
    public function execute(array $filters = []): array
    {
        $response = $this->client->get('boletos', $filters);
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $bills = [];
        foreach ($items as $item) {
            $bills[] = new Bill(
                $item['id'] ?? null,
                $item['email'] ?? '',
                $item['due_date'] ?? null,
                $item['items'] ?? null,
                $item['status'] ?? null,
                $item['custom_variables'] ?? null,
                $item['created_at'] ?? null,
                $item['updated_at'] ?? null,
            );
        }
        return $bills;
    }
} 