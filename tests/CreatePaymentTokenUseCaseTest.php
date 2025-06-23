<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\PaymentTokens\CreatePaymentTokenUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\PaymentTokens\PaymentToken;
use Psr\Http\Message\ResponseInterface;

class CreatePaymentTokenUseCaseTest extends TestCase
{
    public function testExecuteSuccess(): void
    {
        $payload = [
            'account_id' => 'DDD1234B233A45B694728C1EB6941E2B',
            'method' => 'credit_card',
            'test' => true,
            'data' => [
                'number' => '1111-1111-1111-1111',
                'verification_value' => '213',
                'first_name' => 'José',
                'last_name' => 'Silva',
                'month' => '05',
                'year' => '2026',
            ],
        ];

        $apiResponse = [
            'id' => 'tok_123456',
            'method' => 'credit_card',
            'test' => true,
            'token' => 'tok_123456',
            'extra_info' => null,
        ];

        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn(json_encode($apiResponse));
        $httpClient->expects($this->once())
            ->method('post')
            ->with('/v1/payment_token', $payload)
            ->willReturn($responseMock);

        $useCase = new CreatePaymentTokenUseCase($httpClient);
        $token = $useCase->execute($payload);

        $this->assertInstanceOf(PaymentToken::class, $token);
        $this->assertEquals('tok_123456', $token->getId());
        $this->assertEquals('credit_card', $token->getMethod());
        $this->assertTrue($token->isTest());
        $this->assertEquals('tok_123456', $token->getToken());
        $this->assertNull($token->getExtraInfo());
    }

    public function testExecuteFailure(): void
    {
        $payload = [
            'account_id' => 'DDD1234B233A45B694728C1EB6941E2B',
            'method' => 'credit_card',
            'test' => true,
            'data' => [
                'number' => '1111-1111-1111-1111',
                'verification_value' => '213',
                'first_name' => 'José',
                'last_name' => 'Silva',
                'month' => '05',
                'year' => '2026',
            ],
        ];

        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn(json_encode(['unexpected' => 'response']));
        $httpClient->expects($this->once())
            ->method('post')
            ->with('/v1/payment_token', $payload)
            ->willReturn($responseMock);

        $useCase = new CreatePaymentTokenUseCase($httpClient);

        $this->expectException(Exception::class);
        $useCase->execute($payload);
    }
} 