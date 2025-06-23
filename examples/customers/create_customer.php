<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Customers\CreateCustomerUseCase;

$useCase = new CreateCustomerUseCase($client);

try {
    $customer = $useCase->execute([
        'email' => 'cliente@exemplo.com',
        'name' => 'Cliente Exemplo',
    ]);
    print_r($customer);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 