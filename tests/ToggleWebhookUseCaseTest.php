<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Webhooks\ToggleWebhookUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;
use Psr\Http\Message\ResponseInterface;

class ToggleWebhookUseCaseTest extends TestCase
{
    public function testExecuteReturnsToggledWebhook(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(new class {
            public function __toString() {
                return $this->getContents();
            }
            public function getContents() {
                return json_encode([
                    'id' => 'wh5',
                    'event' => 'invoice.paid',
                    'url' => 'https://meusite.com/webhook-paid',
                    'mode' => 'production',
                    'authorization' => null
                ]);
            }
        });
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new ToggleWebhookUseCase($mockClient);
        $webhook = $useCase->execute('wh5', false);

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertEquals('wh5', $webhook->id);
        $this->assertEquals('invoice.paid', $webhook->event);
        $this->assertEquals('https://meusite.com/webhook-paid', $webhook->url);
        $this->assertEquals('production', $webhook->mode);
        $this->assertNull($webhook->authorization);
    }
} 