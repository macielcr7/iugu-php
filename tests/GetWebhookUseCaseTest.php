<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Webhooks\GetWebhookUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;
use Psr\Http\Message\ResponseInterface;

class GetWebhookUseCaseTest extends TestCase
{
    public function testExecuteReturnsWebhook(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'wh4',
            'event' => 'customer.created',
            'url' => 'https://meusite.com/webhook-customer',
            'enabled' => true,
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetWebhookUseCase($mockClient);
        $webhook = $useCase->execute('wh4');

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertEquals('wh4', $webhook->id);
        $this->assertEquals('customer.created', $webhook->event);
        $this->assertEquals('https://meusite.com/webhook-customer', $webhook->url);
        $this->assertTrue($webhook->enabled);
    }
} 