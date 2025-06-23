<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Bills\CreateBillUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Bills\Bill;
use Psr\Http\Message\ResponseInterface;

class CreateBillUseCaseTest extends TestCase
{
    public function testExecuteReturnsBill(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'b1',
            'email' => 'boleto@exemplo.com',
            'due_date' => '2024-12-01',
            'items' => [['description' => 'Parcela', 'quantity' => 1, 'price_cents' => 1000]],
            'status' => 'pending',
        ]));
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new CreateBillUseCase($mockClient);
        $bill = $useCase->execute([
            'email' => 'boleto@exemplo.com',
            'due_date' => '2024-12-01',
            'items' => [['description' => 'Parcela', 'quantity' => 1, 'price_cents' => 1000]],
        ]);

        $this->assertInstanceOf(Bill::class, $bill);
        $this->assertEquals('b1', $bill->id);
        $this->assertEquals('boleto@exemplo.com', $bill->email);
        $this->assertEquals('2024-12-01', $bill->dueDate);
        $this->assertEquals('pending', $bill->status);
    }
} 