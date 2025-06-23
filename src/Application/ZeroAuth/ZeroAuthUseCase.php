<?php

declare(strict_types=1);

namespace Iugu\Application\ZeroAuth;

use Iugu\Domain\ZeroAuth\ZeroAuthResult;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;

class ZeroAuthUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $token
     * @return ZeroAuthResult
     * @throws Exception
     */
    public function execute(string $token): ZeroAuthResult
    {
        $payload = ['token' => $token];
        $response = $this->httpClient->post('/v1/zero_auth', $payload);
        $data = json_decode((string)$response->getBody(), true);

        if (!isset($data['status'])) {
            throw new Exception('Resposta inesperada da API ao validar cartão (Zero Auth).');
        }

        return new ZeroAuthResult(
            $data['status'],
            $data['message'] ?? null,
            $data
        );
    }
} 