<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Plans\ListPlansUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Plans\Plan;
use Psr\Http\Message\ResponseInterface;

class ListPlansUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfPlans(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => 'pl1',
                    'identifier' => 'basic',
                    'name' => 'Básico',
                ],
                [
                    'id' => 'pl2',
                    'identifier' => 'pro',
                    'name' => 'Pro',
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListPlansUseCase($mockClient);
        $plans = $useCase->execute();

        $this->assertIsArray($plans);
        $this->assertCount(2, $plans);
        $this->assertInstanceOf(Plan::class, $plans[0]);
        $this->assertEquals('pl1', $plans[0]->id);
        $this->assertEquals('pl2', $plans[1]->id);
    }
} 