<?php

declare(strict_types=1);

namespace Iugu\Domain\Splits;

final class Split
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name,
        public readonly string $recipient_account_id,
        public readonly bool $permit_aggregated,
        public readonly ?int $percent,
        public readonly ?int $cents,
        public readonly ?int $credit_card_percent,
        public readonly ?int $credit_card_cents,
        public readonly ?int $bank_slip_percent,
        public readonly ?int $bank_slip_cents,
        public readonly ?int $pix_percent,
        public readonly ?int $pix_cents,
        public readonly ?string $created_at,
        public readonly ?string $updated_at
    ) {
    }
} 