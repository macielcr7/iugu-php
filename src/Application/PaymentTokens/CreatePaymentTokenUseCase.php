<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentTokens;

use Iugu\Application\PaymentTokens\Requests\CreatePaymentTokenRequest;
use Iugu\Domain\PaymentTokens\PaymentToken;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;

final class CreatePaymentTokenUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function execute(CreatePaymentTokenRequest $request): PaymentToken
    {
        $response = $this->httpClient->post('/v1/payment_token', $request);
        $data = json_decode($response->getBody()->getContents());

        if (!isset($data->id, $data->method, $data->test, $data->token)) {
            throw new Exception('Resposta inesperada da API ao criar token de pagamento.');
        }

        return new PaymentToken(
            id: $data->id,
            method: $data->method,
            test: (bool)$data->test,
            token: $data->token,
            extra_info: $data->extra_info ?? null
        );
    }
} 