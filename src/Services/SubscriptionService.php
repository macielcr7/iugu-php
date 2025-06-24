<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\Subscriptions\CancelSubscriptionUseCase;
use Iugu\Application\Subscriptions\CreateSubscriptionUseCase;
use Iugu\Application\Subscriptions\GetSubscriptionUseCase;
use Iugu\Application\Subscriptions\ListSubscriptionsUseCase;
use Iugu\Application\Subscriptions\UpdateSubscriptionUseCase;
use Iugu\Application\Subscriptions\Requests\CreateSubscriptionRequest;
use Iugu\Application\Subscriptions\Requests\UpdateSubscriptionRequest;
use Iugu\Domain\Subscriptions\Subscription;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class SubscriptionService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function create(CreateSubscriptionRequest $request): Subscription
    {
        return (new CreateSubscriptionUseCase($this->client))->execute($request);
    }

    public function get(string $id): Subscription
    {
        return (new GetSubscriptionUseCase($this->client))->execute($id);
    }

    /**
     * @return Subscription[]
     */
    public function list(): array
    {
        return (new ListSubscriptionsUseCase($this->client))->execute();
    }

    public function update(string $id, UpdateSubscriptionRequest $request): Subscription
    {
        return (new UpdateSubscriptionUseCase($this->client))->execute($id, $request);
    }

    public function cancel(string $id): Subscription
    {
        return (new CancelSubscriptionUseCase($this->client))->execute($id);
    }
} 