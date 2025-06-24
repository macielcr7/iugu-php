<?php

declare(strict_types=1);

namespace Iugu\Domain\PaymentMethods;

final class PaymentMethod
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $customer_id,
        public readonly string $description,
        public readonly string $token,
        public readonly ?string $item_type = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
        public readonly ?array $data = null,
    ) {}
} 