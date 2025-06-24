<?php

declare(strict_types=1);

namespace Iugu\Application\PaymentMethods\Requests;

final class UpdatePaymentMethodRequest
{
    public function __construct(
        public readonly ?string $description = null,
        public readonly ?string $token = null
    ) {}
} 