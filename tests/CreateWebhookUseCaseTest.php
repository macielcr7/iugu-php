<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Webhooks\CreateWebhookUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;
use Psr\Http\Message\ResponseInterface;
use Iugu\Application\Webhooks\Requests\CreateWebhookRequest;

class CreateWebhookUseCaseTest extends TestCase
{
    public function testExecuteReturnsWebhook(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(new class {
            public function getContents() {
                return json_encode([
                    'id' => 'wh1',
                    'event' => 'invoice.created',
                    'url' => 'https://meusite.com/webhook',
                    'mode' => 'production',
                    'authorization' => null
                ]);
            }
        });
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new CreateWebhookUseCase($mockClient);
        $request = new CreateWebhookRequest(
            event: 'invoice.created',
            url: 'https://meusite.com/webhook'
        );
        $webhook = $useCase->execute($request);

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertEquals('wh1', $webhook->id);
        $this->assertEquals('invoice.created', $webhook->event);
        $this->assertEquals('https://meusite.com/webhook', $webhook->url);
        $this->assertEquals('production', $webhook->mode);
        $this->assertNull($webhook->authorization);
    }
} 