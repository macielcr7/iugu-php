<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Bills\GetBillUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Bills\Bill;
use Psr\Http\Message\ResponseInterface;

class GetBillUseCaseTest extends TestCase
{
    public function testExecuteReturnsBill(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'b2',
            'email' => 'boleto2@exemplo.com',
            'due_date' => '2024-11-01',
            'items' => [['description' => 'Parcela', 'quantity' => 2, 'price_cents' => 2000]],
            'status' => 'paid',
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetBillUseCase($mockClient);
        $bill = $useCase->execute('b2');

        $this->assertInstanceOf(Bill::class, $bill);
        $this->assertEquals('b2', $bill->id);
        $this->assertEquals('boleto2@exemplo.com', $bill->email);
        $this->assertEquals('2024-11-01', $bill->dueDate);
        $this->assertEquals('paid', $bill->status);
    }
} 