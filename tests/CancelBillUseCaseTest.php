<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Bills\CancelBillUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Bills\Bill;
use Psr\Http\Message\ResponseInterface;

class CancelBillUseCaseTest extends TestCase
{
    public function testExecuteReturnsCancelledBill(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'b3',
            'email' => 'cancelado@exemplo.com',
            'due_date' => '2024-09-01',
            'items' => [],
            'status' => 'canceled',
        ]));
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new CancelBillUseCase($mockClient);
        $bill = $useCase->execute('b3');

        $this->assertInstanceOf(Bill::class, $bill);
        $this->assertEquals('b3', $bill->id);
        $this->assertEquals('canceled', $bill->status);
    }
} 