<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\ApiTokens\CreateApiTokenUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\ApiTokens\ApiToken;
use Psr\Http\Message\ResponseInterface;
use Iugu\Application\ApiTokens\Requests\CreateApiTokenRequest;

class CreateApiTokenUseCaseTest extends TestCase
{
    public function testExecuteSuccess(): void
    {
        $accountId = 'acc_123';
        $request = new CreateApiTokenRequest(
            api_type: 'read_write',
            description: 'Token de Teste'
        );
        $apiResponse = [
            'id' => 'tok_123',
            'description' => 'Token de Teste',
            'token' => 'tok_123456',
            'created_at' => '2024-06-01T12:00:00Z',
            'api_type' => 'read_write',
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
            ->with("/v1/{$accountId}/api_tokens", $request->toArray())
            ->willReturn($responseMock);

        $useCase = new CreateApiTokenUseCase($httpClient);
        $token = $useCase->execute($accountId, $request);

        $this->assertInstanceOf(ApiToken::class, $token);
        $this->assertEquals('tok_123', $token->getId());
        $this->assertEquals('Token de Teste', $token->getDescription());
        $this->assertEquals('tok_123456', $token->getToken());
        $this->assertEquals('2024-06-01T12:00:00Z', $token->getCreatedAt());
        $this->assertEquals('read_write', $token->getApiType());
    }

    public function testExecuteFailure(): void
    {
        $accountId = 'acc_123';
        $request = new CreateApiTokenRequest(
            api_type: 'read_write',
            description: 'Token de Teste'
        );
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn(json_encode(['unexpected' => 'response']));
        $httpClient->expects($this->once())
            ->method('post')
            ->with("/v1/{$accountId}/api_tokens", $request->toArray())
            ->willReturn($responseMock);

        $useCase = new CreateApiTokenUseCase($httpClient);
        $this->expectException(Exception::class);
        $useCase->execute($accountId, $request);
    }
} 