<?php

declare(strict_types=1);

namespace Iugu\Application\Invoices;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Invoices\Invoice;

class ListInvoicesUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $filters
     * @return Invoice[]
     * @throws \Exception
     */
    public function execute(array $filters = []): array
    {
        $response = $this->client->get('invoices', $filters);
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $invoices = [];
        foreach ($items as $item) {
            $invoices[] = new Invoice(
                $item['id'] ?? null,
                $item['email'] ?? '',
                $item['due_date'] ?? null,
                $item['items'] ?? [],
                $item['status'] ?? null,
                $item['payer'] ?? null,
                $item['custom_variables'] ?? null,
                $item['created_at'] ?? null,
                $item['updated_at'] ?? null,
            );
        }
        return $invoices;
    }
} 