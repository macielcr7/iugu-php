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
            [
                'id' => 'sp5',
                'name' => 'Split 5',
                'recipient_account_id' => 'acc5',
                'permit_aggregated' => true,
                'percent' => 25.0,
                'cents' => 5000,
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
                'id' => 'sp6',
                'name' => 'Split 6',
                'recipient_account_id' => 'acc6',
                'permit_aggregated' => false,
                'percent' => 75.0,
                'cents' => 6000,
                'credit_card_percent' => null,
                'credit_card_cents' => null,
                'bank_slip_percent' => null,
                'bank_slip_cents' => null,
                'pix_percent' => null,
                'pix_cents' => null,
                'created_at' => '2023-01-01T00:00:00-03:00',
                'updated_at' => '2023-01-01T00:00:00-03:00',
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