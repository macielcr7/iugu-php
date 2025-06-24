<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Common\Requests\AddressRequest;
use Iugu\Application\Common\Requests\PayerRequest;
use Iugu\Application\Invoices\Requests\CreateInvoiceRequest;
use Iugu\Application\Invoices\Requests\InvoiceItemRequest;

try {
    $address = new AddressRequest(
        street: 'Rua Exemplo',
        number: '123',
        city: 'São Paulo',
        state: 'SP',
        country: 'Brasil',
        zip_code: '01234-567'
    );

    $payer = new PayerRequest(
        name: 'Nome do Pagador',
        cpf_cnpj: '123.456.789-00',
        address: $address
    );

    $items = [
        new InvoiceItemRequest(
            description: 'Produto Exemplo 1',
            quantity: 1,
            price_cents: 1000
        ),
        new InvoiceItemRequest(
            description: 'Produto Exemplo 2',
            quantity: 2,
            price_cents: 2500
        ),
    ];

    $invoiceRequest = new CreateInvoiceRequest(
        email: 'cliente@exemplo.com',
        due_date: date('Y-m-d', strtotime('+7 days')),
        items: $items,
        payer: $payer
    );
    $invoice = $iugu->invoices()->create($invoiceRequest);
    print_r($invoice);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 