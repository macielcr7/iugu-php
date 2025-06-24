<?php

declare(strict_types=1);

namespace Iugu\Domain\DirectCharges;

final class CreditCardTransaction
{
    public bool $reversible;
    public string $last4;
    public int $bin;
    public string $brand;
    public string $token;
    public string $message;
    public bool $success;
    public ?string $issuer;
    public string $invoice_id;
    public ?string $lr;

    public function __construct(
        bool $reversible,
        string $last4,
        int $bin,
        string $brand,
        string $token,
        string $message,
        bool $success,
        ?string $issuer,
        string $invoice_id,
        ?string $lr
    ) {
        $this->reversible = $reversible;
        $this->last4 = $last4;
        $this->bin = $bin;
        $this->brand = $brand;
        $this->token = $token;
        $this->message = $message;
        $this->success = $success;
        $this->issuer = $issuer;
        $this->invoice_id = $invoice_id;
        $this->lr = $lr;
    }
} 