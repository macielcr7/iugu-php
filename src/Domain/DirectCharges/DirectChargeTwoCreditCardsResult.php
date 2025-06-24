<?php

declare(strict_types=1);

namespace Iugu\Domain\DirectCharges;

final class DirectChargeTwoCreditCardsResult
{
    public InvoiceStatus $invoice;

    /**
     * @var CreditCardTransaction[]
     */
    public array $credit_card_transactions;

    public ?array $errors;

    /**
     * @param InvoiceStatus $invoice
     * @param CreditCardTransaction[] $credit_card_transactions
     * @param array|null $errors
     */
    public function __construct(
        InvoiceStatus $invoice,
        array $credit_card_transactions,
        ?array $errors = null
    ) {
        $this->invoice = $invoice;
        $this->credit_card_transactions = $credit_card_transactions;
        $this->errors = $errors;
    }
} 