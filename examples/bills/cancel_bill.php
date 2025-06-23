<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Bills\CancelBillUseCase;

$useCase = new CancelBillUseCase($client);

try {
    $bill = $useCase->execute('ID_DO_CARNE');
    print_r($bill);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 