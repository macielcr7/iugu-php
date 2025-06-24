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
                    'name' => 'Split 1',
                    'recipient_account_id' => 'acc1',
                    'permit_aggregated' => true,
                    'percent' => 50.0,
                    'cents' => 1000,
                    'credit_card_percent' => null,
                    'credit_card_cents' => null,
                    'bank_slip_percent' => null,
                    'bank_slip_cents' => null,
                    'pix_percent' => null,
                    'pix_cents' => null,
                    'created_at' => '2023-01-01T00:00:00-03:00',
                    'updated_at' => '2023-01-01T00:00:00-03:00',
                ],
                [
                    'id' => 'sp2',
                    'name' => 'Split 2',
                    'recipient_account_id' => 'acc2',
                    'permit_aggregated' => false,
                    'percent' => 50.0,
                    'cents' => 2000,
                    'credit_card_percent' => null,
                    'credit_card_cents' => null,
                    'bank_slip_percent' => null,
                    'bank_slip_cents' => null,
                    'pix_percent' => null,
                    'pix_cents' => null,
                    'created_at' => '2023-01-01T00:00:00-03:00',
                    'updated_at' => '2023-01-01T00:00:00-03:00',
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