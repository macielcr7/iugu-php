<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Invoices\CreateInvoiceUseCase;

$useCase = new CreateInvoiceUseCase($client);

try {
    $invoice = $useCase->execute([
        'email' => 'cliente@exemplo.com',
        'due_date' => date('Y-m-d', strtotime('+7 days')),
        'items' => [
            [
                'description' => 'Produto Exemplo',
                'quantity' => 1,
                'price_cents' => 1000,
            ],
        ],
    ]);
    print_r($invoice);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 