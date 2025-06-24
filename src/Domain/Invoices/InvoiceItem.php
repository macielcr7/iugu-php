<?php

declare(strict_types=1);

namespace Iugu\Domain\Invoices;

final class InvoiceItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $description,
        public readonly int $price_cents,
        public readonly int $quantity,
        public readonly string $created_at,
        public readonly string $updated_at,
        public readonly ?string $price = null
    ) {
    }
} 