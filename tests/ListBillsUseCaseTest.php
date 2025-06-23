<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Bills\ListBillsUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Bills\Bill;
use Psr\Http\Message\ResponseInterface;

class ListBillsUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfBills(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => 'b1',
                    'email' => 'a@b.com',
                    'due_date' => '2024-10-10',
                    'items' => [],
                    'status' => 'pending',
                ],
                [
                    'id' => 'b2',
                    'email' => 'c@d.com',
                    'due_date' => '2024-10-11',
                    'items' => [],
                    'status' => 'paid',
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListBillsUseCase($mockClient);
        $bills = $useCase->execute();

        $this->assertIsArray($bills);
        $this->assertCount(2, $bills);
        $this->assertInstanceOf(Bill::class, $bills[0]);
        $this->assertEquals('b1', $bills[0]->id);
        $this->assertEquals('b2', $bills[1]->id);
    }
} 