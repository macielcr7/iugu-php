<?php

declare(strict_types=1);

namespace Iugu\Application\Invoices;

use Iugu\Application\Invoices\Requests\CreateInvoiceRequest;
use Iugu\Domain\Common\Address;
use Iugu\Domain\Common\Payer;
use Iugu\Domain\Invoices\Invoice;
use Iugu\Infrastructure\Http\IuguHttpClient;

class CreateInvoiceUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param CreateInvoiceRequest $request
     * @return Invoice
     * @throws \Exception
     */
    public function execute(CreateInvoiceRequest $request): Invoice
    {
        $response = $this->client->post('/v1/invoices', $request);
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
            $items = array_map(function ($item) {
                return new \Iugu\Domain\Invoices\InvoiceItem(
                    id: $item->id ?? null,
                    description: $item->description ?? null,
                    price_cents: $item->price_cents ?? null,
                    quantity: $item->quantity ?? null,
                    created_at: $item->created_at ?? null,
                    updated_at: $item->updated_at ?? null,
                    price: $item->price ?? null
                );
            }, $body->items);
        }

        return new Invoice(
            id: $body->id ?? null,
            email: $body->email ?? $request->email,
            due_date: $body->due_date ?? $request->due_date,
            currency: $body->currency ?? null,
            total_cents: $body->total_cents ?? null,
            status: $body->status ?? null,
            items: $items,
            total: $body->total ?? null,
            secure_url: $body->secure_url ?? null,
            payer: $payer,
            custom_variables: $body->custom_variables ?? $request->custom_variables,
            created_at: $body->created_at ?? $body->created_at_iso ?? null,
            updated_at: $body->updated_at ?? $body->updated_at_iso ?? null,
        );
    }
} 