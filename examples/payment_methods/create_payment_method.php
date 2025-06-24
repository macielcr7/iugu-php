<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\PaymentMethods\Requests\CreatePaymentMethodRequest;

try {
    $customerId = 'CUSTOMER_ID_HERE';
    $paymentToken = 'TOKEN_DE_PAGAMENTO_GERADO';

    $paymentMethodRequest = new CreatePaymentMethodRequest(
        description: 'Meu Cartão de Crédito',
        token: $paymentToken,
        set_as_default: true
    );

    $paymentMethod = $iugu->paymentMethods()->create($customerId, $paymentMethodRequest);
    print_r($paymentMethod);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 