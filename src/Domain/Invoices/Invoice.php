<?php

declare(strict_types=1);

namespace Iugu\Domain\Invoices;

use Iugu\Domain\Common\Payer;

final class Invoice
{
    /**
     * @param InvoiceItem[] $items
     * @param mixed $custom_variables
     */
    public function __construct(
        public readonly ?string $id,
        public readonly string $email,
        public readonly ?string $due_date,
        public readonly ?string $currency,
        public readonly ?int $total_cents,
        public readonly ?string $status = null,
        public readonly array $items = [],
        public readonly ?string $total = null,
        public readonly ?string $secure_url = null,
        public readonly ?Payer $payer = null,
        public readonly ?array $custom_variables = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
    ) {
    }
} 