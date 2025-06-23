<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\ZeroAuth\ZeroAuthUseCase;

$useCase = new ZeroAuthUseCase($client);

try {
    $result = $useCase->execute('TOKEN_DE_PAGAMENTO');
    print_r($result);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 