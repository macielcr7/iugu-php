<?php

declare(strict_types=1);

use Iugu\Application\Invoices\Requests\CreateInvoiceRequest;
use Iugu\Application\Invoices\Requests\InvoiceItemRequest;
use Iugu\Domain\Invoices\Invoice;
use Iugu\Iugu;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use PHPUnit\Framework\MockObject\MockObject;

class CreateInvoiceUseCaseTest extends TestCase
{
    private Iugu $iugu;
    private $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var IuguHttpClient&MockObject $mockClient */
        $mockClient = $this->createMock(IuguHttpClient::class);
        $this->mockClient = $mockClient;
        $this->iugu = new Iugu($this->mockClient);
    }

    public function testExecuteReturnsInvoice(): void
    {
        $responseBody = json_encode([
            'id' => '123',
            'due_date' => '2024-12-31',
            'currency' => 'BRL',
            'total_cents' => 1000,
            'email' => 'cliente@exemplo.com',
            'status' => 'pending',
            'items' => [
                [
                    'id' => 'i1',
                    'description' => 'Item de Teste',
                    'price_cents' => 1000,
                    'quantity' => 1,
                    'created_at' => '2023-01-01T00:00:00-03:00',
                    'updated_at' => '2023-01-01T00:00:00-03:00',
                    'price' => 'R$ 10,00',
                ]
            ],
            'created_at_iso' => '2023-01-01T00:00:00-03:00',
            'updated_at_iso' => '2023-01-01T00:00:00-03:00',
            'total' => 'R$ 10,00',
            'secure_url' => 'https://secure.iugu.com/invoices/123',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('post')->willReturn($mockResponse);

        $request = new CreateInvoiceRequest(
            email: 'cliente@exemplo.com',
            due_date: '2024-12-31',
            items: [
                new InvoiceItemRequest(
                    description: 'Item de Teste',
                    quantity: 1,
                    price_cents: 1000
                )
            ]
        );

        $invoice = $this->iugu->invoices()->create($request);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals('123', $invoice->id);
        $this->assertEquals('cliente@exemplo.com', $invoice->email);
        $this->assertEquals('2024-12-31', $invoice->due_date);
        $this->assertEquals('pending', $invoice->status);
    }
} 