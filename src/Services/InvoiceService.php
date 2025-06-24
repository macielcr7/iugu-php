<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\Invoices\CancelInvoiceUseCase;
use Iugu\Application\Invoices\CreateInvoiceUseCase;
use Iugu\Application\Invoices\GetInvoiceUseCase;
use Iugu\Application\Invoices\ListInvoicesUseCase;
use Iugu\Application\Invoices\Requests\CreateInvoiceRequest;
use Iugu\Domain\Invoices\Invoice;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class InvoiceService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function create(CreateInvoiceRequest $request): Invoice
    {
        return (new CreateInvoiceUseCase($this->client))->execute($request);
    }

    public function get(string $id): Invoice
    {
        return (new GetInvoiceUseCase($this->client))->execute($id);
    }

    /**
     * @return Invoice[]
     */
    public function list(): array
    {
        return (new ListInvoicesUseCase($this->client))->execute();
    }

    public function cancel(string $id): Invoice
    {
        return (new CancelInvoiceUseCase($this->client))->execute($id);
    }
} 