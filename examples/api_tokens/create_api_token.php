<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\ApiTokens\Requests\CreateApiTokenRequest;

try {
    $accountId = 'SUA_ACCOUNT_ID';
    $request = new CreateApiTokenRequest(
        api_type: 'read_write',
        description: 'Token de integração'
    );
    $apiToken = $iugu->apiTokens()->create($accountId, $request);
    print_r($apiToken);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 