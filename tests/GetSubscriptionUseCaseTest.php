<?php

declare(strict_types=1);

use Iugu\Domain\Subscriptions\Subscription;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetSubscriptionUseCaseTest extends TestCase
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

    public function testExecuteReturnsSubscription(): void
    {
        $responseBody = json_encode([
            'id' => 's2',
            'suspended' => false,
            'plan_identifier' => 'plano2',
            'customer_id' => 'c2',
            'expires_at' => null,
            'created_at' => '2023-01-02T00:00:00-03:00',
            'updated_at' => '2023-01-02T00:00:00-03:00',
            'cycles_count' => 2,
            'active' => true,
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $subscription = $this->iugu->subscriptions()->get('s2');

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('s2', $subscription->id);
        $this->assertEquals('c2', $subscription->customer_id);
        $this->assertEquals('plano2', $subscription->plan_identifier);
        $this->assertTrue($subscription->active);
        $this->assertFalse($subscription->suspended);
    }
} 