<?php

declare(strict_types=1);

namespace Iugu\Application\Splits\Requests;

use InvalidArgumentException;

final class SplitRecipientRequest
{
    public string $recipient_account_id;
    public ?int $cents;
    public ?int $percent;
    public ?bool $charge_processing_fee;
    public ?bool $charge_remainder_fee;

    public function __construct(
        string $recipient_account_id,
        ?int $cents = null,
        ?int $percent = null,
        ?bool $charge_processing_fee = null,
        ?bool $charge_remainder_fee = null
    ) {
        if (empty($recipient_account_id)) {
            throw new InvalidArgumentException('Recipient account ID is required.');
        }

        if (is_null($cents) && is_null($percent)) {
            throw new InvalidArgumentException('Either cents or percent must be provided for a recipient.');
        }

        if (!is_null($cents) && !is_null($percent)) {
            throw new InvalidArgumentException('You can only provide cents or percent for a recipient, not both.');
        }

        $this->recipient_account_id = $recipient_account_id;
        $this->cents = $cents;
        $this->percent = $percent;
        $this->charge_processing_fee = $charge_processing_fee;
        $this->charge_remainder_fee = $charge_remainder_fee;
    }

    public function toArray(): array
    {
        return array_filter([
            'recipient_account_id' => $this->recipient_account_id,
            'cents' => $this->cents,
            'percent' => $this->percent,
            'charge_processing_fee' => $this->charge_processing_fee,
            'charge_remainder_fee' => $this->charge_remainder_fee,
        ], fn ($value) => $value !== null);
    }
} 