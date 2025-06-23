<?php

declare(strict_types=1);

namespace Iugu\Domain\Subscriptions;

class Subscription
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $customerId,
        public readonly string $planIdentifier,
        public readonly ?string $status = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?array $customVariables = null,
    ) {}
} 