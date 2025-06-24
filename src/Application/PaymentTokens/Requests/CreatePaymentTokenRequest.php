<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentTokens\Requests;

final class CreatePaymentTokenRequest
{
    public function __construct(
        public readonly string $account_id,
        public readonly string $method,
        public readonly bool $test,
        public readonly array $data
    ) {}
} 