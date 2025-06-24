<?php

declare(strict_types=1);

namespace Iugu\Application\DirectCharges\Requests;

use InvalidArgumentException;

final class ChargeTwoCreditCardsRequest
{
    public string $invoiceId;

    /**
     * @var CreditCardPaymentRequest[]
     */
    public array $creditCardPayments;

    /**
     * @param string $invoiceId
     * @param CreditCardPaymentRequest[] $creditCardPayments
     */
    public function __construct(string $invoiceId, array $creditCardPayments)
    {
        if (empty($invoiceId)) {
            throw new InvalidArgumentException('Invoice ID is required.');
        }

        if (count($creditCardPayments) !== 2) {
            throw new InvalidArgumentException('Exactly two credit card payments are required.');
        }

        $this->invoiceId = $invoiceId;
        $this->creditCardPayments = $creditCardPayments;
    }

    public function toArray(): array
    {
        return [
            'invoice_id' => $this->invoiceId,
            'iugu_credit_card_payment' => array_map(
                fn (CreditCardPaymentRequest $payment) => $payment->toArray(),
                $this->creditCardPayments
            ),
        ];
    }
} 