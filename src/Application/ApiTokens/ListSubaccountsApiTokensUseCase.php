<?php

declare(strict_types=1);

namespace Iugu\Application\ApiTokens;

use Iugu\Domain\ApiTokens\ApiToken;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;

class ListSubaccountsApiTokensUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return ApiToken[]
     * @throws Exception
     */
    public function execute(): array
    {
        $response = $this->httpClient->get('/v1/retrieve_subaccounts_api_token');
        $data = json_decode((string)$response->getBody(), true);

        if (!is_array($data)) {
            throw new Exception('Resposta inesperada da API ao listar API Tokens das subcontas.');
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