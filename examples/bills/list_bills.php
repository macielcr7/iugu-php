<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Bills\ListBillsUseCase;

$useCase = new ListBillsUseCase($client);

try {
    $bills = $useCase->execute();
    print_r($bills);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 