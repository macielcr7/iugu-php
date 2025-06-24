<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\PaymentTokens\Requests\CreatePaymentTokenRequest;

try {
    $request = new CreatePaymentTokenRequest(
        account_id: 'SUA_ACCOUNT_ID',
        method: 'credit_card',
        test: true,
        data: [
            'number' => '4111-1111-1111-1111',
            'verification_value' => '123',
            'first_name' => 'João',
            'last_name' => 'Silva',
            'month' => '12',
            'year' => '2026',
        ]
    );
    $token = $iugu->paymentTokens()->create($request);
    print_r($token);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 