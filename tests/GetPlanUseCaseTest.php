<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Plans\GetPlanUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Plans\Plan;
use Psr\Http\Message\ResponseInterface;

class GetPlanUseCaseTest extends TestCase
{
    public function testExecuteReturnsPlan(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'pl2',
            'identifier' => 'pro-plan',
            'name' => 'Plano Pro',
            'interval' => 'yearly',
            'interval_type' => 2,
            'value_cents' => 19900,
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetPlanUseCase($mockClient);
        $plan = $useCase->execute('pl2');

        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertEquals('pl2', $plan->id);
        $this->assertEquals('pro-plan', $plan->identifier);
        $this->assertEquals('Plano Pro', $plan->name);
        $this->assertEquals('yearly', $plan->interval);
        $this->assertEquals(2, $plan->intervalType);
        $this->assertEquals(19900, $plan->valueCents);
    }
} 