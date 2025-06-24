<?php

declare(strict_types=1);

use Iugu\Application\PaymentMethods\Requests\UpdatePaymentMethodRequest;
use Iugu\Domain\PaymentMethods\PaymentMethod;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class UpdatePaymentMethodUseCaseTest extends TestCase
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

    public function testExecuteReturnsUpdatedPaymentMethod(): void
    {
        $responseBody = json_encode([
            'id' => 'pm3',
            'customer_id' => 'c3',
            'description' => 'Alterado',
            'token' => 'tok3',
            'item_type' => 'credit_card',
            'data' => null,
            'created_at' => '2023-01-03T00:00:00-03:00',
            'updated_at' => '2023-01-03T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('put')->willReturn($mockResponse);

        $request = new UpdatePaymentMethodRequest(
            description: 'Alterado',
            token: 'tok3'
        );

        $paymentMethod = $this->iugu->paymentMethods()->update('c3', 'pm3', $request);

        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals('pm3', $paymentMethod->id);
        $this->assertEquals('Alterado', $paymentMethod->description);
        $this->assertEquals('tok3', $paymentMethod->token);
        $this->assertEquals('credit_card', $paymentMethod->item_type);
    }
} 