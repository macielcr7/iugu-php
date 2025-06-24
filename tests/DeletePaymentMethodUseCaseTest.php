<?php

declare(strict_types=1);

use Iugu\Domain\PaymentMethods\PaymentMethod;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class DeletePaymentMethodUseCaseTest extends TestCase
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

    public function testExecuteReturnsDeletedPaymentMethod(): void
    {
        $responseBody = json_encode([
            'id' => 'pm4',
            'customer_id' => 'c4',
            'description' => 'Deletado',
            'token' => 'tok4',
            'item_type' => 'credit_card',
            'data' => null,
            'created_at' => '2023-01-04T00:00:00-03:00',
            'updated_at' => '2023-01-04T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('delete')->willReturn($mockResponse);

        $paymentMethod = $this->iugu->paymentMethods()->delete('c4', 'pm4');

        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals('pm4', $paymentMethod->id);
        $this->assertEquals('c4', $paymentMethod->customer_id);
        $this->assertEquals('Deletado', $paymentMethod->description);
        $this->assertEquals('tok4', $paymentMethod->token);
        $this->assertEquals('credit_card', $paymentMethod->item_type);
    }
} 