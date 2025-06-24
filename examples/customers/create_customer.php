<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Common\Requests\CustomVariableRequest;
use Iugu\Application\Customers\Requests\CreateCustomerRequest;

try {
    $customVariables = [
        new CustomVariableRequest(name: 'origem', value: 'api-test'),
        new CustomVariableRequest(name: 'user_id', value: '12345'),
    ];

    $customerRequest = new CreateCustomerRequest(
        email: 'cliente.novo@exemplo.com',
        name: 'Cliente Novo Exemplo',
        custom_variables: $customVariables
    );
    $customer = $iugu->customers()->create($customerRequest);
    print_r($customer);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 