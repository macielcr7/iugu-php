<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Splits\Requests\CreateSplitRequest;
use Iugu\Application\Splits\Requests\SplitRecipientRequest;

try {
    $recipients = [
        new SplitRecipientRequest(
            recipient_account_id: 'RECIPIENT_ACCOUNT_ID_1',
            percent: 50
        ),
        new SplitRecipientRequest(
            recipient_account_id: 'RECIPIENT_ACCOUNT_ID_2',
            percent: 50
        ),
    ];

    $splitRequest = new CreateSplitRequest(
        invoice_id: 'INVOICE_ID_HERE',
        recipients: $recipients
    );

    $splits = $iugu->splits()->create($splitRequest);
    print_r($splits);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
} 