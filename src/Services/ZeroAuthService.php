<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\ZeroAuth\ZeroAuthUseCase;
use Iugu\Domain\ZeroAuth\ZeroAuthResult;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class ZeroAuthService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function validate(string $paymentToken): ZeroAuthResult
    {
        return (new ZeroAuthUseCase($this->client))->execute($paymentToken);
    }
} 