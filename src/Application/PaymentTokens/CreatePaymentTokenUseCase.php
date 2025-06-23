<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentTokens;

use Iugu\Domain\PaymentTokens\PaymentToken;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;

class CreatePaymentTokenUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param array{
     *   account_id: string,
     *   method: string,
     *   test: bool,
     *   data: array{
     *     number: string,
     *     verification_value: string,
     *     first_name: string,
     *     last_name: string,
     *     month: string,
     *     year: string
     *   }
     * } $payload
     * @return PaymentToken
     * @throws Exception
     */
    public function execute(array $payload): PaymentToken
    {
        $response = $this->httpClient->post('/v1/payment_token', $payload);
        $data = json_decode((string)$response->getBody(), true);

        if (!isset($data['id'], $data['method'], $data['test'], $data['token'])) {
            throw new Exception('Resposta inesperada da API ao criar token de pagamento.');
        }

        return new PaymentToken(
            $data['id'],
            $data['method'],
            (bool)$data['test'],
            $data['token'],
            $data['extra_info'] ?? null
        );
    }
} 