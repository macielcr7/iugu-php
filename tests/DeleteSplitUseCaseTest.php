<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Splits\DeleteSplitUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;

class DeleteSplitUseCaseTest extends TestCase
{
    public function testExecuteReturnsTrueOnSuccess(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'sp4',
            'name' => 'Split 4',
            'recipient_account_id' => 'acc4',
            'permit_aggregated' => true,
            'percent' => 40.0,
            'cents' => 4000,
            'credit_card_percent' => null,
            'credit_card_cents' => null,
            'bank_slip_percent' => null,
            'bank_slip_cents' => null,
            'pix_percent' => null,
            'pix_cents' => null,
            'created_at' => '2023-01-01T00:00:00-03:00',
            'updated_at' => '2023-01-01T00:00:00-03:00',
        ]));
        $mockClient->method('delete')->willReturn($mockResponse);

        $useCase = new DeleteSplitUseCase($mockClient);
        $result = $useCase->execute('sp4');

        $this->assertInstanceOf(\Iugu\Domain\Splits\Split::class, $result);
        $this->assertEquals('sp4', $result->id);
        $this->assertEquals('acc4', $result->recipient_account_id);
        $this->assertEquals(4000, $result->cents);
        $this->assertEquals(40.0, $result->percent);
    }
} 