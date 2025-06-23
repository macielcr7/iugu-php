<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Webhooks\UpdateWebhookUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;
use Psr\Http\Message\ResponseInterface;

class UpdateWebhookUseCaseTest extends TestCase
{
    public function testExecuteReturnsUpdatedWebhook(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'wh2',
            'event' => 'invoice.paid',
            'url' => 'https://meusite.com/novo-webhook',
            'enabled' => false,
        ]));
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new UpdateWebhookUseCase($mockClient);
        $webhook = $useCase->execute('wh2', [
            'event' => 'invoice.paid',
            'url' => 'https://meusite.com/novo-webhook',
        ]);

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertEquals('wh2', $webhook->id);
        $this->assertEquals('invoice.paid', $webhook->event);
        $this->assertEquals('https://meusite.com/novo-webhook', $webhook->url);
        $this->assertFalse($webhook->enabled);
    }
} 