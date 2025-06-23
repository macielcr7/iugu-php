<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Customers\ListCustomersUseCase;

$useCase = new ListCustomersUseCase($client);

try {
    $customers = $useCase->execute();
    print_r($customers);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 