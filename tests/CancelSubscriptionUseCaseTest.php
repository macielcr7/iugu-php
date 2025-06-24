<?php

declare(strict_types=1);

use Iugu\Domain\Subscriptions\Subscription;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CancelSubscriptionUseCaseTest extends TestCase
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

    public function testExecuteReturnsCancelledSubscription(): void
    {
        $responseBody = json_encode([
            'id' => 's4',
            'suspended' => true,
            'plan_identifier' => 'p4',
            'customer_id' => 'c4',
            'expires_at' => null,
            'created_at' => '2023-01-04T00:00:00-03:00',
            'updated_at' => '2023-01-04T00:00:00-03:00',
            'cycles_count' => 4,
            'active' => false,
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('put')->willReturn($mockResponse);

        $subscription = $this->iugu->subscriptions()->cancel('s4');

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('s4', $subscription->id);
        $this->assertTrue($subscription->suspended);
        $this->assertFalse($subscription->active);
    }
} 