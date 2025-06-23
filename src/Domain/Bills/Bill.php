<?php

declare(strict_types=1);

namespace Iugu\Domain\Bills;

class Bill
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $email,
        public readonly ?string $dueDate = null,
        public readonly ?array $items = null,
        public readonly ?string $status = null,
        public readonly ?array $customVariables = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
    ) {}
} 