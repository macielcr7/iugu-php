<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Webhooks\UpdateWebhookUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;
use Psr\Http\Message\ResponseInterface;
use Iugu\Application\Webhooks\Requests\UpdateWebhookRequest;

class UpdateWebhookUseCaseTest extends TestCase
{
    public function testExecuteReturnsUpdatedWebhook(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(new class {
            public function getContents() {
                return json_encode([
                    'id' => 'wh2',
                    'event' => 'invoice.paid',
                    'url' => 'https://meusite.com/novo-webhook',
                    'mode' => 'production',
                    'authorization' => null
                ]);
            }
        });
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new UpdateWebhookUseCase($mockClient);
        $request = new UpdateWebhookRequest(
            event: 'invoice.paid',
            url: 'https://meusite.com/novo-webhook'
        );
        $webhook = $useCase->execute('wh2', $request);

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertEquals('wh2', $webhook->id);
        $this->assertEquals('invoice.paid', $webhook->event);
        $this->assertEquals('https://meusite.com/novo-webhook', $webhook->url);
        $this->assertEquals('production', $webhook->mode);
        $this->assertNull($webhook->authorization);
    }
} 