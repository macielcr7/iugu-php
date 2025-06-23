<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Webhooks\ListWebhooksUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Webhooks\Webhook;
use Psr\Http\Message\ResponseInterface;

class ListWebhooksUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfWebhooks(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => 'wh1',
                    'event' => 'invoice.created',
                    'url' => 'https://meusite.com/webhook',
                ],
                [
                    'id' => 'wh2',
                    'event' => 'customer.created',
                    'url' => 'https://meusite.com/webhook-customer',
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListWebhooksUseCase($mockClient);
        $webhooks = $useCase->execute();

        $this->assertIsArray($webhooks);
        $this->assertCount(2, $webhooks);
        $this->assertInstanceOf(Webhook::class, $webhooks[0]);
        $this->assertEquals('wh1', $webhooks[0]->id);
        $this->assertEquals('wh2', $webhooks[1]->id);
    }
} 