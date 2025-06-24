<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Bills\Requests\CreateBillRequest;

try {
    $billRequest = new CreateBillRequest(
        email: 'cliente@exemplo.com',
        due_date: date('Y-m-d', strtotime('+7 days')),
        items: [
            [
                'description' => 'Produto Exemplo',
                'quantity' => 1,
                'price_cents' => 1000
            ]
        ]
    );
    $bill = $iugu->bills()->create($billRequest);
    print_r($bill);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 