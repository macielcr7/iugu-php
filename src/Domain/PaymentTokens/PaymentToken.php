<?php

declare(strict_types=1);

namespace Iugu\Domain\PaymentTokens;

final class PaymentToken
{
    public function __construct(
        public readonly string $id,
        public readonly string $method,
        public readonly bool $test,
        public readonly string $token,
        public readonly ?string $extra_info = null
    ) {}
} 