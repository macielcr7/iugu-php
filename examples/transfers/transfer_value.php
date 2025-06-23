<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Transfers\TransferValueUseCase;

$useCase = new TransferValueUseCase($client);

try {
    $transfer = $useCase->execute([
        'amount' => 1000,
        'recipient_id' => 'ID_DA_CONTA_DESTINO',
    ]);
    print_r($transfer);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 