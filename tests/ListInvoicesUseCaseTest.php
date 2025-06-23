<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Invoices\ListInvoicesUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Invoices\Invoice;
use Psr\Http\Message\ResponseInterface;

class ListInvoicesUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfInvoices(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => '1',
                    'email' => 'a@b.com',
                    'due_date' => '2024-10-10',
                    'items' => [],
                    'status' => 'pending',
                ],
                [
                    'id' => '2',
                    'email' => 'c@d.com',
                    'due_date' => '2024-10-11',
                    'items' => [],
                    'status' => 'paid',
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListInvoicesUseCase($mockClient);
        $invoices = $useCase->execute();

        $this->assertIsArray($invoices);
        $this->assertCount(2, $invoices);
        $this->assertInstanceOf(Invoice::class, $invoices[0]);
        $this->assertEquals('1', $invoices[0]->id);
        $this->assertEquals('2', $invoices[1]->id);
    }
} 