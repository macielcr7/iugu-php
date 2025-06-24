<?php

declare(strict_types=1);

use Iugu\Application\Subscriptions\Requests\CreateSubscriptionRequest;
use Iugu\Domain\Subscriptions\Subscription;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CreateSubscriptionUseCaseTest extends TestCase
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
            'id' => 's1',
            'suspended' => false,
            'plan_identifier' => 'basic_plan',
            'customer_id' => 'c1',
            'expires_at' => null,
            'created_at' => '2023-01-01T00:00:00-03:00',
            'updated_at' => '2023-01-01T00:00:00-03:00',
            'cycles_count' => 1,
            'active' => true,
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('post')->willReturn($mockResponse);

        $request = new CreateSubscriptionRequest(
            customer_id: 'c1',
            plan_identifier: 'basic_plan'
        );

        $subscription = $this->iugu->subscriptions()->create($request);

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('s1', $subscription->id);
        $this->assertEquals('c1', $subscription->customer_id);
        $this->assertEquals('basic_plan', $subscription->plan_identifier);
        $this->assertTrue($subscription->active);
    }
} 