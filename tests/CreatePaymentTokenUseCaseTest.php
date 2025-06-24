<?php

declare(strict_types=1);

use Iugu\Application\PaymentTokens\Requests\CreatePaymentTokenRequest;
use Iugu\Domain\PaymentTokens\PaymentToken;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CreatePaymentTokenUseCaseTest extends TestCase
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

    public function testExecuteSuccess(): void
    {
        $request = new CreatePaymentTokenRequest(
            account_id: 'DDD1234B233A45B694728C1EB6941E2B',
            method: 'credit_card',
            test: true,
            data: [
                'number' => '1111-1111-1111-1111',
                'verification_value' => '213',
                'first_name' => 'José',
                'last_name' => 'Silva',
                'month' => '05',
                'year' => '2026',
            ]
        );

        $apiResponse = [
            'id' => 'tok_123456',
            'method' => 'credit_card',
            'test' => true,
            'token' => 'tok_123456',
            'extra_info' => null,
        ];

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn(json_encode($apiResponse));
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('post')->willReturn($mockResponse);

        $token = $this->iugu->paymentTokens()->create($request);

        $this->assertInstanceOf(PaymentToken::class, $token);
        $this->assertEquals('tok_123456', $token->id);
        $this->assertEquals('credit_card', $token->method);
        $this->assertTrue($token->test);
        $this->assertEquals('tok_123456', $token->token);
        $this->assertNull($token->extra_info);
    }

    public function testExecuteFailure(): void
    {
        $request = new CreatePaymentTokenRequest(
            account_id: 'DDD1234B233A45B694728C1EB6941E2B',
            method: 'credit_card',
            test: true,
            data: [
                'number' => '1111-1111-1111-1111',
                'verification_value' => '213',
                'first_name' => 'José',
                'last_name' => 'Silva',
                'month' => '05',
                'year' => '2026',
            ]
        );

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn(json_encode(['unexpected' => 'response']));
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('post')->willReturn($mockResponse);

        $this->expectException(Exception::class);
        $this->iugu->paymentTokens()->create($request);
    }
} 