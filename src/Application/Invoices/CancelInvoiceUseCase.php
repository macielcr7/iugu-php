<?php

declare(strict_types=1);

namespace Iugu\Application\Invoices;

use Iugu\Domain\Common\Address;
use Iugu\Domain\Common\Payer;
use Iugu\Domain\Invoices\Invoice;
use Iugu\Domain\Invoices\InvoiceItem;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class CancelInvoiceUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function execute(string $id): Invoice
    {
        $response = $this->client->put("/v1/invoices/$id/cancel");
        $body = json_decode($response->getBody()->getContents());

        $payer = null;
        if (isset($body->payer)) {
            $payerAddress = new Address(
                street: $body->payer->address->street ?? '',
                number: $body->payer->address->number ?? '',
                city: $body->payer->address->city ?? '',
                state: $body->payer->address->state ?? '',
                country: $body->payer->address->country ?? '',
                zip_code: $body->payer->address->zip_code ?? '',
                district: $body->payer->address->district ?? null,
                complement: $body->payer->address->complement ?? null
            );
            $payer = new Payer(
                name: $body->payer->name ?? '',
                cpf_cnpj: $body->payer->cpf_cnpj ?? '',
                address: $payerAddress,
                phone_prefix: $body->payer->phone_prefix ?? null,
                phone: $body->payer->phone ?? null,
                email: $body->payer->email ?? null
            );
        }

        $items = [];
        if (!empty($body->items)) {
            $items = array_map(static fn ($item) => new InvoiceItem(
                id: $item->id,
                description: $item->description,
                price_cents: $item->price_cents,
                quantity: $item->quantity,
                created_at: $item->created_at,
                updated_at: $item->updated_at,
                price: $item->price,
            ), $body->items);
        }

        return new Invoice(
            id: $body->id,
            email: $body->email,
            due_date: $body->due_date,
            currency: $body->currency ?? null,
            total_cents: $body->total_cents ?? null,
            status: $body->status ?? null,
            items: $items,
            total: $body->total ?? null,
            secure_url: $body->secure_url ?? null,
            payer: $payer,
            custom_variables: $body->custom_variables ?? null,
            created_at: $body->created_at ?? null,
            updated_at: $body->updated_at ?? null,
        );
    }
} 