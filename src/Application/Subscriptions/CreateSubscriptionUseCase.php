<?php

declare(strict_types=1);

namespace Iugu\Application\Subscriptions;

use Iugu\Application\Subscriptions\Requests\CreateSubscriptionRequest;
use Iugu\Domain\Common\CustomVariable;
use Iugu\Domain\Subscriptions\Subscription;
use Iugu\Domain\Subscriptions\SubscriptionSubItem;
use Iugu\Infrastructure\Http\IuguHttpClient;

class CreateSubscriptionUseCase
{
    public function __construct(private IuguHttpClient $client)
    {
    }

    /**
     * @param CreateSubscriptionRequest $request
     * @return Subscription
     * @throws \Exception
     */
    public function execute(CreateSubscriptionRequest $request): Subscription
    {
        $response = $this->client->post('/v1/subscriptions', $request);
        $body = json_decode($response->getBody()->getContents());

        $customVariables = null;
        if (!empty($body->custom_variables)) {
            $customVariables = array_map(
                fn (object $cv) => new CustomVariable(name: $cv->name, value: $cv->value),
                $body->custom_variables
            );
        }

        $subitems = null;
        if (!empty($body->subitems)) {
            $subitems = array_map(
                fn (object $item) => new SubscriptionSubItem(
                    id: $item->id,
                    description: $item->description,
                    quantity: $item->quantity,
                    price_cents: $item->price_cents,
                    recurrent: $item->recurrent
                ),
                $body->subitems
            );
        }

        return new Subscription(
            id: $body->id ?? null,
            suspended: $body->suspended ?? null,
            plan_identifier: $body->plan_identifier ?? null,
            customer_id: $body->customer_id ?? null,
            expires_at: $body->expires_at ?? null,
            created_at: $body->created_at ?? null,
            updated_at: $body->updated_at ?? null,
            cycles_count: $body->cycles_count ?? null,
            active: $body->active ?? null,
            custom_variables: $customVariables,
            subitems: $subitems
        );
    }
} 