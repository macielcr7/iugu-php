<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\ApiTokens\CreateApiTokenUseCase;
use Iugu\Application\ApiTokens\Requests\CreateApiTokenRequest;
use Iugu\Domain\ApiTokens\ApiToken;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class ApiTokenService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function create(string $accountId, CreateApiTokenRequest $request): ApiToken
    {
        return (new CreateApiTokenUseCase($this->client))->execute($accountId, $request);
    }
} 