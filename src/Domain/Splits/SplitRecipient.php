<?php

declare(strict_types=1);

namespace Iugu\Domain\Splits;

class SplitRecipient
{
    public function __construct(
        public readonly string $recipient_account_id,
        public readonly string $name,
        public readonly ?int $cents = null,
        public readonly ?int $percent = null
    ) {}
} 