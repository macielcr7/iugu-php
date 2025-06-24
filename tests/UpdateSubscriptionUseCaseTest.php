<?php

declare(strict_types=1);

use Iugu\Application\Subscriptions\Requests\UpdateSubscriptionRequest;
use Iugu\Domain\Subscriptions\Subscription;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class UpdateSubscriptionUseCaseTest extends TestCase
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

    public function testExecuteReturnsUpdatedSubscription(): void
    {
        $responseBody = json_encode([
            'id' => 's3',
            'suspended' => false,
            'plan_identifier' => 'p3',
            'customer_id' => 'c3',
            'expires_at' => null,
            'created_at' => '2023-01-03T00:00:00-03:00',
            'updated_at' => '2023-01-03T00:00:00-03:00',
            'cycles_count' => 3,
            'active' => true,
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('put')->willReturn($mockResponse);

        $request = new UpdateSubscriptionRequest(
            plan_identifier: 'p3'
        );

        $subscription = $this->iugu->subscriptions()->update('s3', $request);

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('s3', $subscription->id);
        $this->assertEquals('c3', $subscription->customer_id);
        $this->assertEquals('p3', $subscription->plan_identifier);
        $this->assertTrue($subscription->active);
        $this->assertFalse($subscription->suspended);
    }
} 