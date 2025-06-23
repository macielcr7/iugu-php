<?php

declare(strict_types=1);

namespace Iugu\Application\ApiTokens;

use Iugu\Domain\ApiTokens\ApiToken;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;

class ListApiTokensUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $accountId
     * @return ApiToken[]
     * @throws Exception
     */
    public function execute(string $accountId): array
    {
        $response = $this->httpClient->get("/v1/{$accountId}/api_tokens");
        $data = json_decode((string)$response->getBody(), true);

        if (!is_array($data)) {
            throw new Exception('Resposta inesperada da API ao listar API Tokens.');
        }

        $tokens = [];
        foreach ($data as $item) {
            if (!isset($item['id'], $item['description'], $item['token'], $item['created_at'])) {
                continue;
            }
            $tokens[] = new ApiToken(
                $item['id'],
                $item['description'],
                $item['token'],
                $item['created_at'],
                $item['api_type'] ?? null
            );
        }
        return $tokens;
    }
} 