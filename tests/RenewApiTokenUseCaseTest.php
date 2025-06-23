<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\ApiTokens\RenewApiTokenUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;

class RenewApiTokenUseCaseTest extends TestCase
{
    public function testExecuteSuccess(): void
    {
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $httpClient->expects($this->once())
            ->method('post')
            ->with('/v1/profile/renew_access_token')
            ->willReturn($responseMock);

        $useCase = new RenewApiTokenUseCase($httpClient);
        $result = $useCase->execute();
        $this->assertTrue($result);
    }

    public function testExecuteFailure(): void
    {
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(400);
        $httpClient->expects($this->once())
            ->method('post')
            ->with('/v1/profile/renew_access_token')
            ->willReturn($responseMock);

        $useCase = new RenewApiTokenUseCase($httpClient);
        $this->expectException(Exception::class);
        $useCase->execute();
    }
} 