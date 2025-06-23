<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Subscriptions\CancelSubscriptionUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Subscriptions\Subscription;
use Psr\Http\Message\ResponseInterface;

class CancelSubscriptionUseCaseTest extends TestCase
{
    public function testExecuteReturnsCancelledSubscription(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 's4',
            'customer_id' => 'c4',
            'plan_identifier' => 'p4',
            'status' => 'suspended',
        ]));
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new CancelSubscriptionUseCase($mockClient);
        $subscription = $useCase->execute('s4');

        $this->assertInstanceOf(Subscription::class, $subscription);
        $this->assertEquals('s4', $subscription->id);
        $this->assertEquals('suspended', $subscription->status);
    }
} 