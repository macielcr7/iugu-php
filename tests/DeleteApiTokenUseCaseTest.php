<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\ApiTokens\DeleteApiTokenUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;

class DeleteApiTokenUseCaseTest extends TestCase
{
    public function testExecuteSuccess(): void
    {
        $accountId = 'acc_123';
        $tokenId = 'tok_123';
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(204);
        $httpClient->expects($this->once())
            ->method('delete')
            ->with("/v1/{$accountId}/api_tokens/{$tokenId}")
            ->willReturn($responseMock);

        $useCase = new DeleteApiTokenUseCase($httpClient);
        $result = $useCase->execute($accountId, $tokenId);
        $this->assertTrue($result);
    }

    public function testExecuteFailure(): void
    {
        $accountId = 'acc_123';
        $tokenId = 'tok_123';
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(400);
        $httpClient->expects($this->once())
            ->method('delete')
            ->with("/v1/{$accountId}/api_tokens/{$tokenId}")
            ->willReturn($responseMock);

        $useCase = new DeleteApiTokenUseCase($httpClient);
        $this->expectException(Exception::class);
        $useCase->execute($accountId, $tokenId);
    }
} 