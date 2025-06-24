<?php

declare(strict_types=1);

use Iugu\Domain\Subscriptions\Subscription;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ListSubscriptionsUseCaseTest extends TestCase
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

    public function testExecuteReturnsArrayOfSubscriptions(): void
    {
        $responseBody = json_encode([
            'items' => [
                [
                    'id' => 's1',
                    'suspended' => false,
                    'plan_identifier' => 'basic_plan',
                    'customer_id' => 'c1',
                    'expires_at' => null,
                    'created_at' => '2023-01-01T00:00:00-03:00',
                    'updated_at' => '2023-01-01T00:00:00-03:00',
                    'cycles_count' => 1,
                    'active' => true,
                ],
                [
                    'id' => 's2',
                    'suspended' => true,
                    'plan_identifier' => 'premium_plan',
                    'customer_id' => 'c2',
                    'expires_at' => '2024-01-01T00:00:00-03:00',
                    'created_at' => '2023-01-02T00:00:00-03:00',
                    'updated_at' => '2023-01-02T00:00:00-03:00',
                    'cycles_count' => 5,
                    'active' => false,
                ]
            ]
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $subscriptions = $this->iugu->subscriptions()->list();

        $this->assertIsArray($subscriptions);
        $this->assertCount(2, $subscriptions);
        $this->assertInstanceOf(Subscription::class, $subscriptions[0]);
        $this->assertEquals('s1', $subscriptions[0]->id);
        $this->assertEquals('s2', $subscriptions[1]->id);
        $this->assertFalse($subscriptions[0]->suspended);
        $this->assertTrue($subscriptions[1]->suspended);
    }
} 