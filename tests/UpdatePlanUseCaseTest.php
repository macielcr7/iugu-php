<?php

declare(strict_types=1);

use Iugu\Application\Plans\Requests\UpdatePlanRequest;
use Iugu\Domain\Plans\Plan;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class UpdatePlanUseCaseTest extends TestCase
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

    public function testExecuteReturnsUpdatedPlan(): void
    {
        $responseBody = json_encode([
            'id' => 'pl3',
            'identifier' => 'premium',
            'name' => 'Premium',
            'interval' => 1,
            'interval_type' => 'months',
            'created_at' => '2023-01-03T00:00:00-03:00',
            'updated_at' => '2023-01-03T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('put')->willReturn($mockResponse);

        $request = new UpdatePlanRequest(
            identifier: 'premium',
            name: 'Premium',
            interval: 1,
            interval_type: 'months',
        );

        $plan = $this->iugu->plans()->update('pl3', $request);

        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertEquals('pl3', $plan->id);
        $this->assertEquals('premium', $plan->identifier);
        $this->assertEquals('Premium', $plan->name);
        $this->assertEquals(1, $plan->interval);
        $this->assertEquals('months', $plan->interval_type);
    }
} 