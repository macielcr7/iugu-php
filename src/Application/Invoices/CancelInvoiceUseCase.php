<?php

declare(strict_types=1);

namespace Iugu\Application\Invoices;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Invoices\Invoice;

class CancelInvoiceUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @return Invoice
     * @throws \Exception
     */
    public function execute(string $id): Invoice
    {
        $response = $this->client->put('invoices/' . $id . '/cancel');
        $body = json_decode((string) $response->getBody(), true);

        return new Invoice(
            $body['id'] ?? null,
            $body['email'] ?? '',
            $body['due_date'] ?? null,
            $body['items'] ?? [],
            $body['status'] ?? null,
            $body['payer'] ?? null,
            $body['custom_variables'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
        );
    }
} 