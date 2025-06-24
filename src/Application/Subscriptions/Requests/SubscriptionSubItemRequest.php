<?php

declare(strict_types=1);

namespace Iugu\Application\Subscriptions\Requests;

use InvalidArgumentException;

final class SubscriptionSubItemRequest
{
    public function __construct(
        public readonly string $description,
        public readonly int $price_cents,
        public readonly int $quantity = 1,
        public readonly bool $recurrent = true,
    ) {
        if (empty($description)) {
            throw new InvalidArgumentException('Subitem description is required.');
        }
        if ($price_cents <= 0) {
            throw new InvalidArgumentException('Subitem price must be positive.');
        }
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Subitem quantity must be positive.');
        }
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'price_cents' => $this->price_cents,
            'quantity' => $this->quantity,
            'recurrent' => $this->recurrent,
        ];
    }
} 