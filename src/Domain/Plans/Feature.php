<?php

declare(strict_types=1);

namespace Iugu\Domain\Plans;

class Feature
{
    public function __construct(
        public readonly string $name,
        public readonly string $identifier,
        public readonly int $value
    ) {}
} 