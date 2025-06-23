<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\ApiTokens\CreateApiTokenUseCase;

$useCase = new CreateApiTokenUseCase($client);

try {
    $apiToken = $useCase->execute('SUA_ACCOUNT_ID', [
        'api_type' => 'read_write',
        'description' => 'Token de integração',
    ]);
    print_r($apiToken);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 