<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Customers\Requests\UpdateCustomerRequest;

try {
    $updateRequest = new UpdateCustomerRequest(
        name: 'Nome Atualizado',
        email: 'novoemail@exemplo.com'
    );
    $customer = $iugu->customers()->update('ID_DO_CLIENTE', $updateRequest);
    print_r($customer);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 