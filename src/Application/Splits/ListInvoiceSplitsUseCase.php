<?php

declare(strict_types=1);

namespace Iugu\Application\Splits;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Splits\Split;

class ListInvoiceSplitsUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $invoiceId
     * @return Split[]
     * @throws \Exception
     */
    public function execute(string $invoiceId): array
    {
        $response = $this->client->get('invoices/' . $invoiceId . '/splits');
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $splits = [];
        foreach ($items as $item) {
            $splits[] = new Split(
                $item['id'] ?? null,
                $item['recipient_account_id'] ?? '',
                $item['cents'] ?? null,
                $item['percent'] ?? null,
                $item['type'] ?? null,
                $item['created_at'] ?? null,
                $item['updated_at'] ?? null,
                $item['data'] ?? null,
            );
        }
        return $splits;
    }
} 