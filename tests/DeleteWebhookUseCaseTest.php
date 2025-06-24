<?php

declare(strict_types=1);

use Iugu\Domain\Webhooks\Webhook;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class DeleteWebhookUseCaseTest extends TestCase
{
    private Iugu $iugu;
    private $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var IuguHttpClient&MockObject $mockClient */
        $mockClient = $this->createMock(IuguHttpClient::class);
        $this->mockClient = $mockClient;
        $this->iugu = new Iugu($this->mockClient);
    }

    public function testExecuteReturnsDeletedWebhook(): void
    {
        $responseBody = json_encode([
            'id' => 'wh3',
            'event' => 'invoice.created',
            'url' => 'https://meusite.com/webhook',
            'mode' => 'production',
            'authorization' => 'token123',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('delete')->willReturn($mockResponse);

        $webhook = $this->iugu->webhooks()->delete('wh3');

        $this->assertInstanceOf(Webhook::class, $webhook);
        $this->assertEquals('wh3', $webhook->id);
        $this->assertEquals('invoice.created', $webhook->event);
        $this->assertEquals('https://meusite.com/webhook', $webhook->url);
        $this->assertEquals('production', $webhook->mode);
        $this->assertEquals('token123', $webhook->authorization);
    }
} 