<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Invoices\GetInvoiceUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Invoices\Invoice;
use Psr\Http\Message\ResponseInterface;

class GetInvoiceUseCaseTest extends TestCase
{
    public function testExecuteReturnsInvoice(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => '456',
            'email' => 'cliente2@exemplo.com',
            'due_date' => '2024-11-30',
            'items' => [['description' => 'Serviço', 'quantity' => 2, 'price_cents' => 2000]],
            'status' => 'paid',
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetInvoiceUseCase($mockClient);
        $invoice = $useCase->execute('456');

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals('456', $invoice->id);
        $this->assertEquals('cliente2@exemplo.com', $invoice->email);
        $this->assertEquals('2024-11-30', $invoice->dueDate);
        $this->assertEquals('paid', $invoice->status);
    }
} 