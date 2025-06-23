<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Customers\DeleteCustomerUseCase;

$useCase = new DeleteCustomerUseCase($client);

try {
    $result = $useCase->execute('ID_DO_CLIENTE');
    print_r($result);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 