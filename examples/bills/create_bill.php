<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Bills\CreateBillUseCase;

$useCase = new CreateBillUseCase($client);

try {
    $bill = $useCase->execute([
        'customer_id' => 'ID_DO_CLIENTE',
        'installments' => 2,
        'description' => 'Carnê Exemplo',
        'price_cents' => 50000,
        'invoice_payable_with_pix' => true,
        'started_at' => date('Y-m-d'),
    ]);
    print_r($bill);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 