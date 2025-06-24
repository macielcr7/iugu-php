<?php

declare(strict_types=1);

namespace Iugu\Application\Plans\Requests;

final class UpdatePlanRequest
{
    public function __construct(
        public readonly ?string $identifier = null,
        public readonly ?string $name = null,
        public readonly ?int $interval = null,
        public readonly ?string $interval_type = null,
        public readonly ?array $prices = null,
        public readonly ?array $features = null
    ) {}
} 