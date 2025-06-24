<?php

require __DIR__ . '/../bootstrap.php';

try {
    $result = $iugu->zeroAuth()->validate('TOKEN_DE_PAGAMENTO');
    print_r($result);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 