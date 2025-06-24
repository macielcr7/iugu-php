<?php

declare(strict_types=1);

namespace Iugu\Application\Invoices\Requests;

use InvalidArgumentException;

final class InvoiceItemRequest
{
    public string $description;
    public int $quantity;
    public int $price_cents;

    public function __construct(
        string $description,
        int $quantity,
        int $price_cents
    ) {
        if (empty($description)) {
            throw new InvalidArgumentException('Item description is required.');
        }
        if ($quantity <= 0) {
            throw new InvalidArgumentException('Item quantity must be positive.');
        }
        if ($price_cents <= 0) {
            throw new InvalidArgumentException('Item price must be positive.');
        }

        $this->description = $description;
        $this->quantity = $quantity;
        $this->price_cents = $price_cents;
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price_cents' => $this->price_cents,
        ];
    }
} 