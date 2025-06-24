<?php

declare(strict_types=1);

use Iugu\Domain\Plans\Plan;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ListPlansUseCaseTest extends TestCase
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

    public function testExecuteReturnsArrayOfPlans(): void
    {
        $responseBody = json_encode([
            'items' => [
                [
                    'id' => 'pl1',
                    'identifier' => 'basic',
                    'name' => 'Básico',
                    'interval' => 1,
                    'interval_type' => 'months',
                    'created_at' => '2023-01-01T00:00:00-03:00',
                    'updated_at' => '2023-01-01T00:00:00-03:00',
                ],
                [
                    'id' => 'pl2',
                    'identifier' => 'pro',
                    'name' => 'Pro',
                    'interval' => 12,
                    'interval_type' => 'months',
                    'created_at' => '2023-01-02T00:00:00-03:00',
                    'updated_at' => '2023-01-02T00:00:00-03:00',
                ]
            ]
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $plans = $this->iugu->plans()->list();

        $this->assertIsArray($plans);
        $this->assertCount(2, $plans);
        $this->assertInstanceOf(Plan::class, $plans[0]);
        $this->assertEquals('pl1', $plans[0]->id);
        $this->assertEquals('pl2', $plans[1]->id);
    }
} 