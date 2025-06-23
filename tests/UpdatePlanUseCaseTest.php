<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Plans\UpdatePlanUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Plans\Plan;
use Psr\Http\Message\ResponseInterface;

class UpdatePlanUseCaseTest extends TestCase
{
    public function testExecuteReturnsUpdatedPlan(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'pl3',
            'identifier' => 'premium',
            'name' => 'Premium',
            'interval' => 'monthly',
            'interval_type' => 1,
            'value_cents' => 29900,
        ]));
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new UpdatePlanUseCase($mockClient);
        $plan = $useCase->execute('pl3', [
            'identifier' => 'premium',
            'name' => 'Premium',
            'interval' => 'monthly',
            'interval_type' => 1,
            'value_cents' => 29900,
        ]);

        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertEquals('pl3', $plan->id);
        $this->assertEquals('premium', $plan->identifier);
        $this->assertEquals('Premium', $plan->name);
        $this->assertEquals('monthly', $plan->interval);
        $this->assertEquals(1, $plan->intervalType);
        $this->assertEquals(29900, $plan->valueCents);
    }
} 