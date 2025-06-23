<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Splits\ListInvoiceSplitsUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Splits\Split;
use Psr\Http\Message\ResponseInterface;

class ListInvoiceSplitsUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfSplits(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => 'sp5',
                    'recipient_account_id' => 'acc5',
                    'cents' => 5000,
                    'percent' => 25.0,
                ],
                [
                    'id' => 'sp6',
                    'recipient_account_id' => 'acc6',
                    'cents' => 6000,
                    'percent' => 75.0,
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListInvoiceSplitsUseCase($mockClient);
        $splits = $useCase->execute('inv1');

        $this->assertIsArray($splits);
        $this->assertCount(2, $splits);
        $this->assertInstanceOf(Split::class, $splits[0]);
        $this->assertEquals('sp5', $splits[0]->id);
        $this->assertEquals('sp6', $splits[1]->id);
    }
} 