<?php

declare(strict_types=1);

namespace Iugu\Domain\DirectCharges;

final class InvoiceStatus
{
    public string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }
} 