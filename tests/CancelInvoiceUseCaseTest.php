<?php

declare(strict_types=1);

use Iugu\Domain\Invoices\Invoice;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CancelInvoiceUseCaseTest extends TestCase
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

    public function testExecuteReturnsCancelledInvoice(): void
    {
        $responseBody = json_encode([
            'id' => '789',
            'status' => 'canceled',
            'due_date' => '2024-11-30',
            'email' => 'cliente1@exemplo.com',
            'currency' => 'BRL',
            'total_cents' => 1000,
            'items' => [],
            'total' => 'R$ 10,00',
            'secure_url' => 'http://test1.com',
            'created_at' => '2023-01-01T00:00:00-03:00',
            'updated_at' => '2023-01-01T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('put')->willReturn($mockResponse);

        $invoice = $this->iugu->invoices()->cancel('789');

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals('789', $invoice->id);
        $this->assertEquals('canceled', $invoice->status);
    }
} 