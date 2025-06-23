<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Splits\CreateSplitUseCase;

$useCase = new CreateSplitUseCase($client);

try {
    $split = $useCase->execute([
        'invoice_id' => 'ID_DA_FATURA',
        'recipient_account_id' => 'ID_DA_CONTA_DESTINO',
        'percentage' => 50,
    ]);
    print_r($split);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 