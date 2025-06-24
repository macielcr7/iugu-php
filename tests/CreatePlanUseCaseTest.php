<?php

declare(strict_types=1);

use Iugu\Application\Plans\Requests\CreatePlanRequest;
use Iugu\Application\Plans\Requests\PlanPriceRequest;
use Iugu\Domain\Plans\Plan;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CreatePlanUseCaseTest extends TestCase
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
            'id' => 'pl1',
            'identifier' => 'basic-plan',
            'name' => 'Plano Básico',
            'interval' => 1,
            'interval_type' => 'months',
            'created_at' => '2023-01-01T00:00:00-03:00',
            'updated_at' => '2023-01-01T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('post')->willReturn($mockResponse);

        $request = new CreatePlanRequest(
            name: 'Plano Básico',
            identifier: 'basic-plan',
            interval: 1,
            interval_type: 'months',
            prices: [new PlanPriceRequest('BRL', 9900)],
        );

        $plan = $this->iugu->plans()->create($request);

        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertEquals('pl1', $plan->id);
        $this->assertEquals('basic-plan', $plan->identifier);
        $this->assertEquals('Plano Básico', $plan->name);
        $this->assertEquals(1, $plan->interval);
        $this->assertEquals('months', $plan->interval_type);
    }
} 