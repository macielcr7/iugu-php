<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Webhooks\ListEventsUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;

class ListEventsUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfEvents(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'events' => ['invoice.created', 'invoice.paid', 'customer.created']
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListEventsUseCase($mockClient);
        $events = $useCase->execute();

        $this->assertIsArray($events);
        $this->assertCount(3, $events);
        $this->assertEquals('invoice.created', $events[0]);
        $this->assertEquals('invoice.paid', $events[1]);
        $this->assertEquals('customer.created', $events[2]);
    }
} 