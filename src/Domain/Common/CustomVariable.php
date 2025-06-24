<?php

declare(strict_types=1);

namespace Iugu\Domain\Common;

class CustomVariable
{
    public function __construct(
        public readonly string $name,
        public readonly string $value,
        public readonly ?string $type = null
    ) {}
} 