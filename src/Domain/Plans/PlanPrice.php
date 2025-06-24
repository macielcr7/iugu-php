<?php

declare(strict_types=1);

namespace Iugu\Domain\Plans;

class PlanPrice
{
    public function __construct(
        public readonly string $currency,
        public readonly int $value_cents,
        public readonly ?int $id = null
    ) {}
} 