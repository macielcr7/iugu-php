<?php

require __DIR__ . '/../bootstrap.php';

use Iugu\Application\Common\Requests\CustomVariableRequest;
use Iugu\Application\Subscriptions\CreateSubscriptionUseCase;
use Iugu\Application\Subscriptions\Requests\CreateSubscriptionRequest;
use Iugu\Application\Subscriptions\Requests\SubscriptionSubItemRequest;

$useCase = new CreateSubscriptionUseCase($client);

try {
    $subitems = [
        new SubscriptionSubItemRequest(
            description: 'Item extra 1',
            price_cents: 1000,
            quantity: 1,
            recurrent: true
        ),
    ];

    $customVariables = [
        new CustomVariableRequest(name: 'origin', value: 'example_file'),
    ];

    $subscriptionRequest = new CreateSubscriptionRequest(
        customer_id: 'CUSTOMER_ID_HERE',
        plan_identifier: 'PLAN_IDENTIFIER_HERE',
        subitems: $subitems,
        custom_variables: $customVariables
    );

    $subscription = $useCase->execute($subscriptionRequest);
    print_r($subscription);
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}