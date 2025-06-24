<?php

declare(strict_types=1);

namespace Iugu\Domain\Plans;

class Plan
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $identifier,
        public readonly string $name,
        public readonly ?int $interval = null,
        public readonly ?string $interval_type = null,
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
        public readonly ?array $features = null,
        public readonly ?array $prices = null,
        public readonly ?array $payable_with = null,
        public readonly ?int $max_cycles = null,
    ) {
    }
}