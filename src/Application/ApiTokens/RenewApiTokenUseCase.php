<?php

declare(strict_types=1);

namespace Iugu\Application\ApiTokens;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;

class RenewApiTokenUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function execute(): bool
    {
        $response = $this->httpClient->post('/v1/profile/renew_access_token');
        if ($response->getStatusCode() !== 200) {
            throw new Exception('Erro ao renovar API Token.');
        }
        return true;
    }
} 