<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\Webhooks\CreateWebhookUseCase;
use Iugu\Application\Webhooks\DeleteWebhookUseCase;
use Iugu\Application\Webhooks\GetWebhookUseCase;
use Iugu\Application\Webhooks\ListWebhooksUseCase;
use Iugu\Application\Webhooks\UpdateWebhookUseCase;
use Iugu\Application\Webhooks\Requests\CreateWebhookRequest;
use Iugu\Application\Webhooks\Requests\UpdateWebhookRequest;
use Iugu\Domain\Webhooks\Webhook;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class WebhookService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function create(CreateWebhookRequest $request): Webhook
    {
        return (new CreateWebhookUseCase($this->client))->execute($request);
    }

    public function get(string $id): Webhook
    {
        return (new GetWebhookUseCase($this->client))->execute($id);
    }

    /**
     * @return Webhook[]
     */
    public function list(): array
    {
        return (new ListWebhooksUseCase($this->client))->execute();
    }

    public function update(string $id, UpdateWebhookRequest $request): Webhook
    {
        return (new UpdateWebhookUseCase($this->client))->execute($id, $request);
    }

    public function delete(string $id): Webhook
    {
        return (new DeleteWebhookUseCase($this->client))->execute($id);
    }
} 