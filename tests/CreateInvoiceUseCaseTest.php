<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Invoices\CreateInvoiceUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Invoices\Invoice;
use Psr\Http\Message\ResponseInterface;

class CreateInvoiceUseCaseTest extends TestCase
{
    public function testExecuteReturnsInvoice(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => '123',
            'email' => 'cliente@exemplo.com',
            'due_date' => '2024-12-31',
            'items' => [['description' => 'Produto', 'quantity' => 1, 'price_cents' => 1000]],
            'status' => 'pending',
        ]));
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new CreateInvoiceUseCase($mockClient);
        $invoice = $useCase->execute([
            'email' => 'cliente@exemplo.com',
            'due_date' => '2024-12-31',
            'items' => [['description' => 'Produto', 'quantity' => 1, 'price_cents' => 1000]],
        ]);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals('123', $invoice->id);
        $this->assertEquals('cliente@exemplo.com', $invoice->email);
        $this->assertEquals('2024-12-31', $invoice->dueDate);
        $this->assertEquals('pending', $invoice->status);
    }
} 