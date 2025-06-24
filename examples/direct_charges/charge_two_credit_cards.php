<?php

require_once __DIR__ . '/../bootstrap.php';

use Iugu\Application\DirectCharges\Requests\ChargeTwoCreditCardsRequest;
use Iugu\Application\DirectCharges\Requests\CreditCardPaymentRequest;

// This invoice_id must exist in your iugu account
$invoiceId = 'YOUR_INVOICE_ID';

// These tokens must be generated via iugu.js or Create Token API endpoint
$token1 = 'TOKEN_1';
$token2 = 'TOKEN_2';

$result = $iugu->directCharges()->chargeTwoCreditCards(
    new ChargeTwoCreditCardsRequest(
        invoiceId: $invoiceId,
        creditCardPayments: [
            new CreditCardPaymentRequest(
                token: $token1,
                amount: 5000 // R$ 50,00
            ),
            new CreditCardPaymentRequest(
                token: $token2,
                amount: 3000 // R$ 30,00
            ),
        ]
    )
);

print_r($result); 