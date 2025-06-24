<?php

declare(strict_types=1);

namespace Iugu\Application\Plans\Requests;

use InvalidArgumentException;

final class PlanPriceRequest
{
    public string $currency;
    public int $value_cents;

    public function __construct(string $currency, int $value_cents)
    {
        if (empty($currency)) {
            throw new InvalidArgumentException('Price currency is required.');
        }
        if ($value_cents <= 0) {
            throw new InvalidArgumentException('Price value must be positive.');
        }

        $this->currency = $currency;
        $this->value_cents = $value_cents;
    }

    public function toArray(): array
    {
        return [
            'currency' => $this->currency,
            'value_cents' => $this->value_cents,
        ];
    }
} 