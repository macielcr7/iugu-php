<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods\Requests;

final class CreatePaymentMethodRequest
{
    public function __construct(
        public readonly string $description,
        public readonly string $token,
        public readonly ?bool $set_as_default = null
    ) {}
} 