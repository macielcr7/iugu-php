<?php

declare(strict_types=1);

use Iugu\Domain\Invoices\Invoice;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetInvoiceUseCaseTest extends TestCase
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
            'id' => '456',
            'due_date' => '2024-11-30',
            'email' => 'cliente2@exemplo.com',
            'status' => 'paid',
            'currency' => 'BRL',
            'total_cents' => 2000,
            'items' => [],
            'total' => 'R$ 20,00',
            'secure_url' => 'http://test.com',
            'created_at' => '2023-01-01T00:00:00-03:00',
            'updated_at' => '2023-01-01T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $invoice = $this->iugu->invoices()->get('456');

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals('456', $invoice->id);
        $this->assertEquals('cliente2@exemplo.com', $invoice->email);
        $this->assertEquals('2024-11-30', $invoice->due_date);
        $this->assertEquals('paid', $invoice->status);
    }
} 