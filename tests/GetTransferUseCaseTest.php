<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Transfers\GetTransferUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Transfers\Transfer;
use Psr\Http\Message\ResponseInterface;

class GetTransferUseCaseTest extends TestCase
{
    public function testExecuteReturnsTransfer(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'tr2',
            'receiver_id' => 'acc2',
            'amount' => 10000,
            'status' => 'completed',
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetTransferUseCase($mockClient);
        $transfer = $useCase->execute('tr2');

        $this->assertInstanceOf(Transfer::class, $transfer);
        $this->assertEquals('tr2', $transfer->id);
        $this->assertEquals('acc2', $transfer->receiverId);
        $this->assertEquals(10000, $transfer->amount);
        $this->assertEquals('completed', $transfer->status);
    }
} 