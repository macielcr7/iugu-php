<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\PaymentMethods\ListPaymentMethodsUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentMethods\PaymentMethod;
use Psr\Http\Message\ResponseInterface;

class ListPaymentMethodsUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfPaymentMethods(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => 'pm1',
                    'customer_id' => 'c1',
                    'description' => 'Visa',
                    'token' => 'tok1',
                ],
                [
                    'id' => 'pm2',
                    'customer_id' => 'c1',
                    'description' => 'Master',
                    'token' => 'tok2',
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListPaymentMethodsUseCase($mockClient);
        $methods = $useCase->execute('c1');

        $this->assertIsArray($methods);
        $this->assertCount(2, $methods);
        $this->assertInstanceOf(PaymentMethod::class, $methods[0]);
        $this->assertEquals('pm1', $methods[0]->id);
        $this->assertEquals('pm2', $methods[1]->id);
    }
} 