<?php

declare(strict_types=1);

namespace Iugu\Application\Splits\Requests;

use InvalidArgumentException;

final class CreateSplitRequest
{
    public string $invoice_id;
    /** @var SplitRecipientRequest[] */
    public array $recipients;

    /**
     * @param string $invoice_id
     * @param SplitRecipientRequest[] $recipients
     */
    public function __construct(string $invoice_id, array $recipients)
    {
        if (empty($invoice_id)) {
            throw new InvalidArgumentException('Invoice ID is required.');
        }
        if (empty($recipients)) {
            throw new InvalidArgumentException('At least one recipient is required.');
        }
        $this->invoice_id = $invoice_id;
        $this->recipients = $recipients;
    }

    public function toArray(): array
    {
        return [
            'invoice_id' => $this->invoice_id,
            'recipients' => array_map(
                fn (SplitRecipientRequest $recipient) => $recipient->toArray(),
                $this->recipients
            ),
        ];
    }
} 