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
            'name' => 'Split 3',
            'recipient_account_id' => 'acc3',
            'permit_aggregated' => true,
            'percent' => 30.0,
            'cents' => 3000,
            'credit_card_percent' => null,
            'credit_card_cents' => null,
            'bank_slip_percent' => null,
            'bank_slip_cents' => null,
            'pix_percent' => null,
            'pix_cents' => null,
            'created_at' => '2023-01-01T00:00:00-03:00',
            'updated_at' => '2023-01-01T00:00:00-03:00',
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetSplitUseCase($mockClient);
        $split = $useCase->execute('sp3');

        $this->assertInstanceOf(Split::class, $split);
        $this->assertEquals('sp3', $split->id);
        $this->assertEquals('acc3', $split->recipient_account_id);
        $this->assertEquals(3000, $split->cents);
        $this->assertEquals(30.0, $split->percent);
    }
} 