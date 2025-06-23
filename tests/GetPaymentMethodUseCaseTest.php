<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\PaymentMethods\GetPaymentMethodUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;
use Psr\Http\Message\ResponseInterface;

class GetPaymentMethodUseCaseTest extends TestCase
{
    public function testExecuteReturnsPaymentMethod(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'pm2',
            'customer_id' => 'c2',
            'description' => 'Mastercard',
            'token' => 'tok_456',
            'item_type' => 'credit_card',
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetPaymentMethodUseCase($mockClient);
        $paymentMethod = $useCase->execute('c2', 'pm2');

        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals('pm2', $paymentMethod->id);
        $this->assertEquals('c2', $paymentMethod->customerId);
        $this->assertEquals('Mastercard', $paymentMethod->description);
        $this->assertEquals('tok_456', $paymentMethod->token);
        $this->assertEquals('credit_card', $paymentMethod->itemType);
    }
} 