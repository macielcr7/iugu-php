<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\DirectCharges\ChargeTwoCreditCardsUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\DirectCharges\DirectChargeTwoCreditCardsResult;
use Psr\Http\Message\ResponseInterface;
use Iugu\Application\DirectCharges\Requests\ChargeTwoCreditCardsRequest;
use Iugu\Application\DirectCharges\Requests\CreditCardPaymentRequest;

class ChargeTwoCreditCardsUseCaseTest extends TestCase
{
    public function testExecuteSuccess(): void
    {
        $request = new ChargeTwoCreditCardsRequest(
            invoiceId: '1234567890ABCDEF1234567890ABCDEF',
            creditCardPayments: [
                new CreditCardPaymentRequest('token1', 500),
                new CreditCardPaymentRequest('token2', 500),
            ]
        );
        $apiResponse = [
            'invoice' => [ 'status' => 'paid' ],
            'credit_card_transactions' => [],
            'errors' => null,
        ];
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn(new class($apiResponse) {
                private $data;
                public function __construct($data) { $this->data = $data; }
                public function getContents() { return json_encode($this->data); }
            });
        $httpClient->expects($this->once())
            ->method('post')
            ->with('/v1/charge_two_credit_cards', $request->toArray())
            ->willReturn($responseMock);

        $useCase = new ChargeTwoCreditCardsUseCase($httpClient);
        $result = $useCase->execute($request);

        $this->assertInstanceOf(DirectChargeTwoCreditCardsResult::class, $result);
        $this->assertEquals('paid', $result->invoice->status);
        $this->assertIsArray($result->credit_card_transactions);
        $this->assertNull($result->errors);
    }

    public function testExecuteFailure(): void
    {
        $request = new ChargeTwoCreditCardsRequest(
            invoiceId: '1234567890ABCDEF1234567890ABCDEF',
            creditCardPayments: [
                new CreditCardPaymentRequest('token1', 500),
                new CreditCardPaymentRequest('token2', 500),
            ]
        );
        /** @var IuguHttpClient&\PHPUnit\Framework\MockObject\MockObject $httpClient */
        $httpClient = $this->getMockBuilder(IuguHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn(new class {
                public function getContents() { return json_encode(['unexpected' => 'response']); }
            });
        $httpClient->expects($this->once())
            ->method('post')
            ->with('/v1/charge_two_credit_cards', $request->toArray())
            ->willReturn($responseMock);

        $useCase = new ChargeTwoCreditCardsUseCase($httpClient);
        $this->expectException(Exception::class);
        $useCase->execute($request);
    }
} 