<?php

declare(strict_types=1);

namespace Iugu\Application\DirectCharges;

use Iugu\Domain\DirectCharges\DirectChargeTwoCreditCardsResult;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;

class ChargeTwoCreditCardsUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param array $payload
     * @return DirectChargeTwoCreditCardsResult
     * @throws Exception
     */
    public function execute(array $payload): DirectChargeTwoCreditCardsResult
    {
        $response = $this->httpClient->post('/v1/charge_two_credit_cards', $payload);
        $data = json_decode((string)$response->getBody(), true);

        if (!isset($data['id'], $data['status'])) {
            throw new Exception('Resposta inesperada da API ao tentar cobrar com dois cartões.');
        }

        return new DirectChargeTwoCreditCardsResult(
            $data['id'],
            $data['status'],
            $data['errors'] ?? null,
            $data
        );
    }
} 