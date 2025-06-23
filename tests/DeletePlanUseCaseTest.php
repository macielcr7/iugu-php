<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Plans\DeletePlanUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;

class DeletePlanUseCaseTest extends TestCase
{
    public function testExecuteReturnsTrueOnSuccess(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'success' => true
        ]));
        $mockClient->method('delete')->willReturn($mockResponse);

        $useCase = new DeletePlanUseCase($mockClient);
        $result = $useCase->execute('pl4');

        $this->assertTrue($result);
    }
} 