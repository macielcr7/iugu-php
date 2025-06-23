<?php

declare(strict_types=1);

namespace Iugu\Application\Invoices;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Invoices\Invoice;

class CreateInvoiceUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $data
     * @return Invoice
     * @throws \Exception
     */
    public function execute(array $data): Invoice
    {
        $response = $this->client->post('invoices', $data);
        $body = json_decode((string) $response->getBody(), true);

        return new Invoice(
            $body['id'] ?? null,
            $body['email'] ?? $data['email'],
            $body['due_date'] ?? $data['due_date'] ?? null,
            $body['items'] ?? $data['items'],
            $body['status'] ?? null,
            $body['payer'] ?? null,
            $body['custom_variables'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
        );
    }
} 