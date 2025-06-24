<?php

declare(strict_types=1);

use Iugu\Application\Splits\Requests\CreateSplitRequest;
use Iugu\Application\Splits\Requests\SplitRecipientRequest;
use Iugu\Domain\Splits\Split;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CreateSplitUseCaseTest extends TestCase
{
    private Iugu $iugu;
    private $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var IuguHttpClient&MockObject $mockClient */
        $mockClient = $this->createMock(IuguHttpClient::class);
        $this->mockClient = $mockClient;
        $this->iugu = new Iugu($this->mockClient);
    }

    public function testExecuteReturnsSplit(): void
    {
        $responseBody = json_encode([
            [
                'id' => 'sp1',
                'name' => 'Split Teste',
                'recipient_account_id' => 'acc1',
                'permit_aggregated' => true,
                'percent' => null,
                'cents' => 1000,
                'credit_card_percent' => null,
                'credit_card_cents' => null,
                'bank_slip_percent' => null,
                'bank_slip_cents' => null,
                'pix_percent' => null,
                'pix_cents' => null,
                'created_at' => '2023-01-01T00:00:00-03:00',
                'updated_at' => '2023-01-01T00:00:00-03:00',
            ]
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($responseBody);
        $this->mockClient->method('post')->willReturn($mockResponse);

        $request = new CreateSplitRequest(
            invoice_id: 'inv1',
            recipients: [
                new SplitRecipientRequest(
                    recipient_account_id: 'acc1',
                    cents: 1000,
                    percent: null,
                    charge_processing_fee: true,
                    charge_remainder_fee: false
                )
            ]
        );

        $splits = $this->iugu->splits()->create($request);
        // var_dump($splits);

        $this->assertIsArray($splits);
        $this->assertInstanceOf(Split::class, $splits[0]);
        $split = $splits[0];
        $this->assertEquals('sp1', $split->id);
        $this->assertEquals('acc1', $split->recipient_account_id);
        $this->assertEquals(1000, $split->cents);
        $this->assertNull($split->percent);
    }
} 