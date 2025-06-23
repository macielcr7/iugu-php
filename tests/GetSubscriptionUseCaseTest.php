<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Subscriptions\GetSubscriptionUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Subscriptions\Subscription;
use Psr\Http\Message\ResponseInterface;

class GetSubscriptionUseCaseTest extends TestCase
{
    public function testExecuteReturnsSubscription(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 's2',
            'customer_id' => 'c2',
            'plan_identifier' => 'plano2',
            'status' => 'active',
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetSubscriptionUseCase($mockClient);
        $subscription = $useCase->execute('s2');

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('s2', $subscription->id);
        $this->assertEquals('c2', $subscription->customerId);
        $this->assertEquals('plano2', $subscription->planIdentifier);
        $this->assertEquals('active', $subscription->status);
    }
} 