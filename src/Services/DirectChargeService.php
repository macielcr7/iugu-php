<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\DirectCharges\ChargeTwoCreditCardsUseCase;
use Iugu\Application\DirectCharges\Requests\ChargeTwoCreditCardsRequest;
use Iugu\Domain\DirectCharges\DirectChargeTwoCreditCardsResult;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class DirectChargeService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function chargeTwoCreditCards(ChargeTwoCreditCardsRequest $request): DirectChargeTwoCreditCardsResult
    {
        return (new ChargeTwoCreditCardsUseCase($this->client))->execute($request);
    }
} 