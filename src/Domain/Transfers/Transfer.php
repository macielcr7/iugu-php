<?php

declare(strict_types=1);

namespace Iugu\Domain\Transfers;

class Transfer
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $receiverId,
        public readonly int $amount,
        public readonly ?string $status = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?array $data = null,
    ) {}
} 