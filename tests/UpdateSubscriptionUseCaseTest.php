<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Subscriptions\UpdateSubscriptionUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Subscriptions\Subscription;
use Psr\Http\Message\ResponseInterface;

class UpdateSubscriptionUseCaseTest extends TestCase
{
    public function testExecuteReturnsUpdatedSubscription(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 's3',
            'customer_id' => 'c3',
            'plan_identifier' => 'p3',
            'status' => 'active',
        ]));
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new UpdateSubscriptionUseCase($mockClient);
        $subscription = $useCase->execute('s3', [
            'customer_id' => 'c3',
            'plan_identifier' => 'p3',
        ]);

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('s3', $subscription->id);
        $this->assertEquals('c3', $subscription->customerId);
        $this->assertEquals('p3', $subscription->planIdentifier);
        $this->assertEquals('active', $subscription->status);
    }
} 