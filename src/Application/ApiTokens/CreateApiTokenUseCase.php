<?php

declare(strict_types=1);

namespace Iugu\Application\ApiTokens;

use Iugu\Domain\ApiTokens\ApiToken;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;
use Iugu\Application\ApiTokens\Requests\CreateApiTokenRequest;

class CreateApiTokenUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $accountId
     * @param CreateApiTokenRequest $request
     * @return ApiToken
     * @throws Exception
     */
    public function execute(string $accountId, CreateApiTokenRequest $request): ApiToken
    {
        $response = $this->httpClient->post("/v1/{$accountId}/api_tokens", $request->toArray());
        $data = json_decode((string)$response->getBody(), true);

        if (!isset($data['id'], $data['description'], $data['token'], $data['created_at'])) {
            throw new Exception('Resposta inesperada da API ao criar API Token.');
        }

        return new ApiToken(
            $data['id'],
            $data['description'],
            $data['token'],
            $data['created_at'],
            $data['api_type'] ?? null
        );
    }
} 