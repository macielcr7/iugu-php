<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\PaymentMethods\DeletePaymentMethodUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;

class DeletePaymentMethodUseCaseTest extends TestCase
{
    public function testExecuteReturnsTrueOnSuccess(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'success' => true
        ]));
        $mockClient->method('delete')->willReturn($mockResponse);

        $useCase = new DeletePaymentMethodUseCase($mockClient);
        $result = $useCase->execute('c4', 'pm4');

        $this->assertTrue($result);
    }
} 