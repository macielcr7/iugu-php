<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\ApiTokens\ListSubaccountsApiTokensUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\ApiTokens\ApiToken;
use Psr\Http\Message\ResponseInterface;

class ListSubaccountsApiTokensUseCaseTest extends TestCase
{
    public function testExecuteSuccess(): void
    {
        $apiResponse = [
            [
                'id' => 'tok_1',
                'description' => 'Token 1',
                'token' => 'tok_abc',
                'created_at' => '2024-06-01T12:00:00Z',
                'api_type' => 'read',
            ],
            [
                'id' => 'tok_2',
                'description' => 'Token 2',
                'token' => 'tok_def',
                'created_at' => '2024-06-02T12:00:00Z',
                'api_type' => 'write',
            ],
        ];
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn(json_encode($apiResponse));
        $httpClient->expects($this->once())
            ->method('get')
            ->with('/v1/retrieve_subaccounts_api_token')
            ->willReturn($responseMock);

        $useCase = new ListSubaccountsApiTokensUseCase($httpClient);
        $tokens = $useCase->execute();

        $this->assertIsArray($tokens);
        $this->assertCount(2, $tokens);
        $this->assertInstanceOf(ApiToken::class, $tokens[0]);
        $this->assertEquals('tok_1', $tokens[0]->getId());
        $this->assertEquals('Token 1', $tokens[0]->getDescription());
        $this->assertEquals('tok_abc', $tokens[0]->getToken());
        $this->assertEquals('2024-06-01T12:00:00Z', $tokens[0]->getCreatedAt());
        $this->assertEquals('read', $tokens[0]->getApiType());
    }

    public function testExecuteFailure(): void
    {
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn('null');
        $httpClient->expects($this->once())
            ->method('get')
            ->with('/v1/retrieve_subaccounts_api_token')
            ->willReturn($responseMock);

        $useCase = new ListSubaccountsApiTokensUseCase($httpClient);
        $this->expectException(Exception::class);
        $useCase->execute();
    }
} 