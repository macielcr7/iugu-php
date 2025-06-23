<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\PaymentMethods\UpdatePaymentMethodUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;
use Psr\Http\Message\ResponseInterface;

class UpdatePaymentMethodUseCaseTest extends TestCase
{
    public function testExecuteReturnsUpdatedPaymentMethod(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'pm3',
            'customer_id' => 'c3',
            'description' => 'Alterado',
            'token' => 'tok3',
            'item_type' => 'credit_card',
        ]));
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new UpdatePaymentMethodUseCase($mockClient);
        $paymentMethod = $useCase->execute('c3', 'pm3', [
            'description' => 'Alterado',
            'token' => 'tok3',
        ]);

        $this->assertInstanceOf(PaymentMethod::class, $paymentMethod);
        $this->assertEquals('pm3', $paymentMethod->id);
        $this->assertEquals('Alterado', $paymentMethod->description);
        $this->assertEquals('tok3', $paymentMethod->token);
        $this->assertEquals('credit_card', $paymentMethod->itemType);
    }
} 