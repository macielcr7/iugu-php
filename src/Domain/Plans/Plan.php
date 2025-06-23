<?php

declare(strict_types=1);

namespace Iugu\Domain\Plans;

class Plan
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $identifier,
        public readonly string $name,
        public readonly ?string $interval = null,
        public readonly ?int $intervalType = null,
        public readonly ?int $valueCents = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?array $features = null,
    ) {}
} 