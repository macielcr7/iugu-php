<?php

declare(strict_types=1);

namespace Iugu\Domain\PaymentMethods;

class PaymentMethod
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $customerId,
        public readonly string $description,
        public readonly string $token,
        public readonly ?string $itemType = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?array $data = null,
    ) {}
} 