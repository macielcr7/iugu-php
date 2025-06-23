<?php

declare(strict_types=1);

namespace Iugu\Domain\Invoices;

class Invoice
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $email,
        public readonly ?string $dueDate,
        public readonly array $items,
        public readonly ?string $status = null,
        public readonly ?array $payer = null,
        public readonly ?array $customVariables = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
    ) {}
} 