<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Splits\CreateSplitUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Splits\Split;
use Psr\Http\Message\ResponseInterface;

class CreateSplitUseCaseTest extends TestCase
{
    public function testExecuteReturnsSplit(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'sp1',
            'recipient_account_id' => 'acc1',
            'cents' => 1000,
            'percent' => 50.0,
            'type' => 'primary',
        ]));
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new CreateSplitUseCase($mockClient);
        $split = $useCase->execute([
            'recipient_account_id' => 'acc1',
            'cents' => 1000,
            'percent' => 50.0,
        ]);

        $this->assertInstanceOf(Split::class, $split);
        $this->assertEquals('sp1', $split->id);
        $this->assertEquals('acc1', $split->recipientAccountId);
        $this->assertEquals(1000, $split->cents);
        $this->assertEquals(50.0, $split->percent);
        $this->assertEquals('primary', $split->type);
    }
} 