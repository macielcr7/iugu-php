<?php

declare(strict_types=1);

use Iugu\Domain\PaymentMethods\PaymentMethod;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ListPaymentMethodsUseCaseTest extends TestCase
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

    public function testExecuteReturnsArrayOfPaymentMethods(): void
    {
        $responseBody = json_encode([
            'items' => [
                [
                    'id' => 'pm1',
                    'customer_id' => 'c1',
                    'description' => 'Visa',
                    'token' => 'tok1',
                    'item_type' => 'credit_card',
                    'data' => null,
                    'created_at' => '2023-01-01T00:00:00-03:00',
                    'updated_at' => '2023-01-01T00:00:00-03:00',
                ],
                [
                    'id' => 'pm2',
                    'customer_id' => 'c1',
                    'description' => 'Master',
                    'token' => 'tok2',
                    'item_type' => 'credit_card',
                    'data' => null,
                    'created_at' => '2023-01-02T00:00:00-03:00',
                    'updated_at' => '2023-01-02T00:00:00-03:00',
                ]
            ]
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $methods = $this->iugu->paymentMethods()->list('c1');

        $this->assertIsArray($methods);
        $this->assertCount(2, $methods);
        $this->assertInstanceOf(PaymentMethod::class, $methods[0]);
        $this->assertEquals('pm1', $methods[0]->id);
        $this->assertEquals('pm2', $methods[1]->id);
    }
} 