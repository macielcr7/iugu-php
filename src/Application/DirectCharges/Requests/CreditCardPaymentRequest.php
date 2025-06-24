<?php

declare(strict_types=1);

namespace Iugu\Application\DirectCharges\Requests;

use InvalidArgumentException;

final class CreditCardPaymentRequest
{
    public string $token;

    public int $amount;

    public function __construct(string $token, int $amount)
    {
        if (empty($token)) {
            throw new InvalidArgumentException('Token is required.');
        }

        if ($amount <= 0) {
            throw new InvalidArgumentException('Amount must be greater than zero.');
        }

        $this->token = $token;
        $this->amount = $amount;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'amount' => $this->amount,
        ];
    }
} 