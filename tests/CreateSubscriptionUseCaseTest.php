<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Subscriptions\CreateSubscriptionUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Subscriptions\Subscription;
use Psr\Http\Message\ResponseInterface;

class CreateSubscriptionUseCaseTest extends TestCase
{
    public function testExecuteReturnsSubscription(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 's1',
            'customer_id' => 'c1',
            'plan_identifier' => 'plano1',
            'status' => 'active',
        ]));
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new CreateSubscriptionUseCase($mockClient);
        $subscription = $useCase->execute([
            'customer_id' => 'c1',
            'plan_identifier' => 'plano1',
        ]);

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('s1', $subscription->id);
        $this->assertEquals('c1', $subscription->customerId);
        $this->assertEquals('plano1', $subscription->planIdentifier);
        $this->assertEquals('active', $subscription->status);
    }
} 