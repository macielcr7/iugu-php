<?php

declare(strict_types=1);

namespace Iugu\Application\Invoices;

use Iugu\Domain\Common\Address;
use Iugu\Domain\Common\Payer;
use Iugu\Domain\Invoices\Invoice;
use Iugu\Domain\Invoices\InvoiceItem;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class ListInvoicesUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return Invoice[]
     */
    public function execute(array $filters = []): array
    {
        $response = $this->client->get('/v1/invoices', $filters);
        $body = json_decode($response->getBody()->getContents());

        return array_map(function ($invoiceData) {
            $payer = null;
            if (isset($invoiceData->payer)) {
                $payerAddress = new Address(
                    street: $invoiceData->payer->address->street ?? '',
                    number: $invoiceData->payer->address->number ?? '',
                    city: $invoiceData->payer->address->city ?? '',
                    state: $invoiceData->payer->address->state ?? '',
                    country: $invoiceData->payer->address->country ?? '',
                    zip_code: $invoiceData->payer->address->zip_code ?? '',
                    district: $invoiceData->payer->address->district ?? null,
                    complement: $invoiceData->payer->address->complement ?? null
                );
                $payer = new Payer(
                    name: $invoiceData->payer->name ?? '',
                    cpf_cnpj: $invoiceData->payer->cpf_cnpj ?? '',
                    address: $payerAddress,
                    phone_prefix: $invoiceData->payer->phone_prefix ?? null,
                    phone: $invoiceData->payer->phone ?? null,
                    email: $invoiceData->payer->email ?? null
                );
            }

            $items = [];
            if (!empty($invoiceData->items)) {
                $items = array_map(static fn ($item) => new InvoiceItem(
                    id: $item->id,
                    description: $item->description,
                    price_cents: $item->price_cents,
                    quantity: $item->quantity,
                    created_at: $item->created_at,
                    updated_at: $item->updated_at,
                    price: $item->price,
                ), $invoiceData->items);
            }

            return new Invoice(
                id: $invoiceData->id,
                email: $invoiceData->email,
                due_date: $invoiceData->due_date,
                currency: $invoiceData->currency ?? null,
                total_cents: $invoiceData->total_cents ?? null,
                status: $invoiceData->status ?? null,
                items: $items,
                total: $invoiceData->total ?? null,
                secure_url: $invoiceData->secure_url ?? null,
                payer: $payer,
                custom_variables: $invoiceData->custom_variables ?? null,
                created_at: $invoiceData->created_at ?? null,
                updated_at: $invoiceData->updated_at ?? null,
            );
        }, $body->items);
    }
} 