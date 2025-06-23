<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Webhooks\DeleteWebhookUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;

class DeleteWebhookUseCaseTest extends TestCase
{
    public function testExecuteReturnsTrueOnSuccess(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'success' => true
        ]));
        $mockClient->method('delete')->willReturn($mockResponse);

        $useCase = new DeleteWebhookUseCase($mockClient);
        $result = $useCase->execute('wh3');

        $this->assertTrue($result);
    }
} 