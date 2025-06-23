<?php

declare(strict_types=1);

namespace Iugu\Domain\Customers;

class Customer
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $email,
        public readonly ?string $name = null,
        public readonly ?string $cpfCnpj = null,
        public readonly ?string $notes = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?array $customVariables = null,
    ) {}
} 