<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks\Requests;

use InvalidArgumentException;

final class CreateWebhookRequest
{
    public string $event;
    public string $url;
    public ?string $authorization;

    public function __construct(
        string $event,
        string $url,
        ?string $authorization = null
    ) {
        if (empty($event)) {
            throw new InvalidArgumentException('Webhook event is required.');
        }

        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('A valid URL is required for the webhook.');
        }

        $this->event = $event;
        $this->url = $url;
        $this->authorization = $authorization;
    }

    public function toArray(): array
    {
        return array_filter([
            'event' => $this->event,
            'url' => $this->url,
            'authorization' => $this->authorization,
        ], fn ($value) => $value !== null);
    }
} 