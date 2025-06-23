<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Plans\CreatePlanUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Plans\Plan;
use Psr\Http\Message\ResponseInterface;

class CreatePlanUseCaseTest extends TestCase
{
    public function testExecuteReturnsPlan(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'pl1',
            'identifier' => 'basic-plan',
            'name' => 'Plano Básico',
            'interval' => 'monthly',
            'interval_type' => 1,
            'value_cents' => 9900,
        ]));
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new CreatePlanUseCase($mockClient);
        $plan = $useCase->execute([
            'identifier' => 'basic-plan',
            'name' => 'Plano Básico',
            'interval' => 'monthly',
            'interval_type' => 1,
            'value_cents' => 9900,
        ]);

        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertEquals('pl1', $plan->id);
        $this->assertEquals('basic-plan', $plan->identifier);
        $this->assertEquals('Plano Básico', $plan->name);
        $this->assertEquals('monthly', $plan->interval);
        $this->assertEquals(1, $plan->intervalType);
        $this->assertEquals(9900, $plan->valueCents);
    }
} 