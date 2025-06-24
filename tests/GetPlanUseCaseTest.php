<?php

declare(strict_types=1);

use Iugu\Domain\Plans\Plan;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetPlanUseCaseTest extends TestCase
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

    public function testExecuteReturnsPlan(): void
    {
        $responseBody = json_encode([
            'id' => 'pl2',
            'identifier' => 'pro-plan',
            'name' => 'Plano Pro',
            'interval' => 12,
            'interval_type' => 'months',
            'created_at' => '2023-01-02T00:00:00-03:00',
            'updated_at' => '2023-01-02T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $plan = $this->iugu->plans()->get('pl2');

        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertEquals('pl2', $plan->id);
        $this->assertEquals('pro-plan', $plan->identifier);
        $this->assertEquals('Plano Pro', $plan->name);
        $this->assertEquals(12, $plan->interval);
        $this->assertEquals('months', $plan->interval_type);
    }
} 