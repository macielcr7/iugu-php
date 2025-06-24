<?php

declare(strict_types=1);

use Iugu\Domain\Invoices\Invoice;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ListInvoicesUseCaseTest extends TestCase
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

    public function testExecuteReturnsArrayOfInvoices(): void
    {
        $responseBody = json_encode([
            'items' => [
                [
                    'id' => '1',
                    'due_date' => '2024-11-30',
                    'email' => 'cliente1@exemplo.com',
                    'status' => 'paid',
                    'currency' => 'BRL',
                    'total_cents' => 1000,
                    'items' => [],
                    'total' => 'R$ 10,00',
                    'secure_url' => 'http://test1.com',
                    'created_at' => '2023-01-01T00:00:00-03:00',
                    'updated_at' => '2023-01-01T00:00:00-03:00',
                ],
                [
                    'id' => '2',
                    'due_date' => '2024-12-01',
                    'email' => 'cliente2@exemplo.com',
                    'status' => 'pending',
                    'currency' => 'BRL',
                    'total_cents' => 2000,
                    'items' => [],
                    'total' => 'R$ 20,00',
                    'secure_url' => 'http://test2.com',
                    'created_at' => '2023-01-02T00:00:00-03:00',
                    'updated_at' => '2023-01-02T00:00:00-03:00',
                ],
            ]
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $invoices = $this->iugu->invoices()->list();

        $this->assertIsArray($invoices);
        $this->assertCount(2, $invoices);
        $this->assertInstanceOf(Invoice::class, $invoices[0]);
        $this->assertEquals('1', $invoices[0]->id);
        $this->assertEquals('2', $invoices[1]->id);
    }
} 