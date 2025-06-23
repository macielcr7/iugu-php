<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Invoices\CancelInvoiceUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Invoices\Invoice;
use Psr\Http\Message\ResponseInterface;

class CancelInvoiceUseCaseTest extends TestCase
{
    public function testExecuteReturnsCancelledInvoice(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => '789',
            'email' => 'cancelado@exemplo.com',
            'due_date' => '2024-09-01',
            'items' => [],
            'status' => 'canceled',
        ]));
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new CancelInvoiceUseCase($mockClient);
        $invoice = $useCase->execute('789');

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals('789', $invoice->id);
        $this->assertEquals('canceled', $invoice->status);
    }
} 