<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\DirectCharges\ChargeTwoCreditCardsUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\DirectCharges\DirectChargeTwoCreditCardsResult;
use Psr\Http\Message\ResponseInterface;

class ChargeTwoCreditCardsUseCaseTest extends TestCase
{
    public function testExecuteSuccess(): void
    {
        $payload = [
            'api_token' => 'live_api_token',
            'invoiced_id' => '1234567890ABCDEF1234567890ABCDEF',
            'iugu_credit_card_payment' => [
                ['token' => 'token1', 'amount' => 500],
                ['token' => 'token2', 'amount' => 500],
            ],
        ];
        $apiResponse = [
            'id' => 'charge_123',
            'status' => 'paid',
            'errors' => null,
        ];
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn(json_encode($apiResponse));
        $httpClient->expects($this->once())
            ->method('post')
            ->with('/v1/charge_two_credit_cards', $payload)
            ->willReturn($responseMock);

        $useCase = new ChargeTwoCreditCardsUseCase($httpClient);
        $result = $useCase->execute($payload);

        $this->assertInstanceOf(DirectChargeTwoCreditCardsResult::class, $result);
        $this->assertEquals('charge_123', $result->getId());
        $this->assertEquals('paid', $result->getStatus());
        $this->assertNull($result->getErrors());
    }

    public function testExecuteFailure(): void
    {
        $payload = [
            'api_token' => 'live_api_token',
            'invoiced_id' => '1234567890ABCDEF1234567890ABCDEF',
            'iugu_credit_card_payment' => [
                ['token' => 'token1', 'amount' => 500],
                ['token' => 'token2', 'amount' => 500],
            ],
        ];
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn(json_encode(['unexpected' => 'response']));
        $httpClient->expects($this->once())
            ->method('post')
            ->with('/v1/charge_two_credit_cards', $payload)
            ->willReturn($responseMock);

        $useCase = new ChargeTwoCreditCardsUseCase($httpClient);
        $this->expectException(Exception::class);
        $useCase->execute($payload);
    }
} 