<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Splits\ListSplitsUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Splits\Split;
use Psr\Http\Message\ResponseInterface;

class ListSplitsUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfSplits(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => 'sp1',
                    'recipient_account_id' => 'acc1',
                    'cents' => 1000,
                    'percent' => 50.0,
                ],
                [
                    'id' => 'sp2',
                    'recipient_account_id' => 'acc2',
                    'cents' => 2000,
                    'percent' => 50.0,
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListSplitsUseCase($mockClient);
        $splits = $useCase->execute();

        $this->assertIsArray($splits);
        $this->assertCount(2, $splits);
        $this->assertInstanceOf(Split::class, $splits[0]);
        $this->assertEquals('sp1', $splits[0]->id);
        $this->assertEquals('sp2', $splits[1]->id);
    }
} 