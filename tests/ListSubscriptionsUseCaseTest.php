<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Subscriptions\ListSubscriptionsUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Subscriptions\Subscription;
use Psr\Http\Message\ResponseInterface;

class ListSubscriptionsUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfSubscriptions(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => 's1',
                    'customer_id' => 'c1',
                    'plan_identifier' => 'p1',
                    'status' => 'active',
                ],
                [
                    'id' => 's2',
                    'customer_id' => 'c2',
                    'plan_identifier' => 'p2',
                    'status' => 'suspended',
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListSubscriptionsUseCase($mockClient);
        $subscriptions = $useCase->execute();

        $this->assertIsArray($subscriptions);
        $this->assertCount(2, $subscriptions);
        $this->assertInstanceOf(Subscription::class, $subscriptions[0]);
        $this->assertEquals('s1', $subscriptions[0]->id);
        $this->assertEquals('s2', $subscriptions[1]->id);
    }
} 