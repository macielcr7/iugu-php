<?php

declare(strict_types=1);

use Iugu\Domain\PaymentMethods\PaymentMethod;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetPaymentMethodUseCaseTest extends TestCase
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

    public function testExecuteReturnsPaymentMethod(): void
    {
        $responseBody = json_encode([
            'id' => 'pm2',
            'customer_id' => 'c2',
            'description' => 'Mastercard',
            'token' => 'tok_456',
            'item_type' => 'credit_card',
            'data' => null,
            'created_at' => '2023-01-02T00:00:00-03:00',
            'updated_at' => '2023-01-02T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $paymentMethod = $this->iugu->paymentMethods()->get('c2', 'pm2');

        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals('pm2', $paymentMethod->id);
        $this->assertEquals('c2', $paymentMethod->customer_id);
        $this->assertEquals('Mastercard', $paymentMethod->description);
        $this->assertEquals('tok_456', $paymentMethod->token);
        $this->assertEquals('credit_card', $paymentMethod->item_type);
    }
} 