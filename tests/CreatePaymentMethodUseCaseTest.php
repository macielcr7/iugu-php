<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\PaymentMethods\CreatePaymentMethodUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;
use Psr\Http\Message\ResponseInterface;

class CreatePaymentMethodUseCaseTest extends TestCase
{
    public function testExecuteReturnsPaymentMethod(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'pm1',
            'customer_id' => 'c1',
            'description' => 'Cartão Visa',
            'token' => 'tok_123',
            'item_type' => 'credit_card',
        ]));
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new CreatePaymentMethodUseCase($mockClient);
        $paymentMethod = $useCase->execute('c1', [
            'description' => 'Cartão Visa',
            'token' => 'tok_123',
        ]);

        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals('pm1', $paymentMethod->id);
        $this->assertEquals('c1', $paymentMethod->customerId);
        $this->assertEquals('Cartão Visa', $paymentMethod->description);
        $this->assertEquals('tok_123', $paymentMethod->token);
        $this->assertEquals('credit_card', $paymentMethod->itemType);
    }
} 