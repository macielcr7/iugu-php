<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\PaymentMethods\DeletePaymentMethodUseCase;

$useCase = new DeletePaymentMethodUseCase($client);

try {
    $result = $useCase->execute('ID_DO_CLIENTE', 'ID_DA_FORMA_PAGAMENTO');
    print_r($result);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 