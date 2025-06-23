<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Transfers\ListTransfersUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Transfers\Transfer;
use Psr\Http\Message\ResponseInterface;

class ListTransfersUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfTransfers(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => 'tr1',
                    'receiver_id' => 'acc1',
                    'amount' => 5000,
                ],
                [
                    'id' => 'tr2',
                    'receiver_id' => 'acc2',
                    'amount' => 10000,
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListTransfersUseCase($mockClient);
        $transfers = $useCase->execute();

        $this->assertIsArray($transfers);
        $this->assertCount(2, $transfers);
        $this->assertInstanceOf(Transfer::class, $transfers[0]);
        $this->assertEquals('tr1', $transfers[0]->id);
        $this->assertEquals('tr2', $transfers[1]->id);
    }
} 