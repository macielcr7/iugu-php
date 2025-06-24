<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\PaymentTokens\CreatePaymentTokenUseCase;
use Iugu\Application\PaymentTokens\Requests\CreatePaymentTokenRequest;
use Iugu\Domain\PaymentTokens\PaymentToken;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class PaymentTokenService
{
    public function __construct(private IuguHttpClient $client) {}

    public function create(CreatePaymentTokenRequest $request): PaymentToken
    {
        return (new CreatePaymentTokenUseCase($this->client))->execute($request);
    }
} 