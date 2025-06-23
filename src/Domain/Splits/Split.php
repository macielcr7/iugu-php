<?php

declare(strict_types=1);

namespace Iugu\Domain\Splits;

class Split
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $recipientAccountId,
        public readonly ?int $cents = null,
        public readonly ?float $percent = null,
        public readonly ?string $type = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?array $data = null,
    ) {}
} 