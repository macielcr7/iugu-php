<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Splits\DeleteSplitUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;

class DeleteSplitUseCaseTest extends TestCase
{
    public function testExecuteReturnsTrueOnSuccess(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'success' => true
        ]));
        $mockClient->method('delete')->willReturn($mockResponse);

        $useCase = new DeleteSplitUseCase($mockClient);
        $result = $useCase->execute('sp4');

        $this->assertTrue($result);
    }
} 