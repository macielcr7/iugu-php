<?php

declare(strict_types=1);

namespace Iugu\Application\ApiTokens;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;

class DeleteApiTokenUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $accountId
     * @param string $tokenId
     * @return bool
     * @throws Exception
     */
    public function execute(string $accountId, string $tokenId): bool
    {
        $response = $this->httpClient->delete("/v1/{$accountId}/api_tokens/{$tokenId}");
        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 204) {
            throw new Exception('Erro ao remover API Token.');
        }
        return true;
    }
} 