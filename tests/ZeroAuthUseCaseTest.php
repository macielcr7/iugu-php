<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\ZeroAuth\ZeroAuthUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\ZeroAuth\ZeroAuthResult;
use Psr\Http\Message\ResponseInterface;

class ZeroAuthUseCaseTest extends TestCase
{
    public function testExecuteSuccess(): void
    {
        $token = 'tok_123';
        $apiResponse = [
            'status' => 'valid',
            'message' => 'Cartão válido',
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
            ->with('/v1/zero_auth', ['token' => $token])
            ->willReturn($responseMock);

        $useCase = new ZeroAuthUseCase($httpClient);
        $result = $useCase->execute($token);

        $this->assertInstanceOf(ZeroAuthResult::class, $result);
        $this->assertEquals('valid', $result->getStatus());
        $this->assertEquals('Cartão válido', $result->getMessage());
    }

    public function testExecuteFailure(): void
    {
        $token = 'tok_123';
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn(json_encode(['unexpected' => 'response']));
        $httpClient->expects($this->once())
            ->method('post')
            ->with('/v1/zero_auth', ['token' => $token])
            ->willReturn($responseMock);

        $useCase = new ZeroAuthUseCase($httpClient);
        $this->expectException(Exception::class);
        $useCase->execute($token);
    }
} 