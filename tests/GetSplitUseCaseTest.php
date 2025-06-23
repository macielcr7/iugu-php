<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Splits\GetSplitUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Splits\Split;
use Psr\Http\Message\ResponseInterface;

class GetSplitUseCaseTest extends TestCase
{
    public function testExecuteReturnsSplit(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'sp3',
            'recipient_account_id' => 'acc3',
            'cents' => 3000,
            'percent' => 30.0,
            'type' => 'secondary',
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetSplitUseCase($mockClient);
        $split = $useCase->execute('sp3');

        $this->assertInstanceOf(Split::class, $split);
        $this->assertEquals('sp3', $split->id);
        $this->assertEquals('acc3', $split->recipientAccountId);
        $this->assertEquals(3000, $split->cents);
        $this->assertEquals(30.0, $split->percent);
        $this->assertEquals('secondary', $split->type);
    }
} 