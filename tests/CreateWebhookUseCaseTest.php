<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Webhooks\CreateWebhookUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;
use Psr\Http\Message\ResponseInterface;

class CreateWebhookUseCaseTest extends TestCase
{
    public function testExecuteReturnsWebhook(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'wh1',
            'event' => 'invoice.created',
            'url' => 'https://meusite.com/webhook',
            'enabled' => true,
        ]));
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new CreateWebhookUseCase($mockClient);
        $webhook = $useCase->execute([
            'event' => 'invoice.created',
            'url' => 'https://meusite.com/webhook',
        ]);

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertEquals('wh1', $webhook->id);
        $this->assertEquals('invoice.created', $webhook->event);
        $this->assertEquals('https://meusite.com/webhook', $webhook->url);
        $this->assertTrue($webhook->enabled);
    }
} 