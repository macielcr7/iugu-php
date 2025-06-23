<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Transfers\TransferValueUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Transfers\Transfer;
use Psr\Http\Message\ResponseInterface;

class TransferValueUseCaseTest extends TestCase
{
    public function testExecuteReturnsTransfer(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'tr1',
            'receiver_id' => 'acc1',
            'amount' => 5000,
            'status' => 'pending',
        ]));
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new TransferValueUseCase($mockClient);
        $transfer = $useCase->execute([
            'receiver_id' => 'acc1',
            'amount' => 5000,
        ]);

        $this->assertInstanceOf(Transfer::class, $transfer);
        $this->assertEquals('tr1', $transfer->id);
        $this->assertEquals('acc1', $transfer->receiverId);
        $this->assertEquals(5000, $transfer->amount);
        $this->assertEquals('pending', $transfer->status);
    }
} 