<?php

declare(strict_types=1);

namespace Iugu\Domain\Subscriptions;

class SubscriptionSubItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $description,
        public readonly int $quantity,
        public readonly int $price_cents,
        public readonly bool $recurrent
    ) {}
} 