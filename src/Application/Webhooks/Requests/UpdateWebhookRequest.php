<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks\Requests;

use InvalidArgumentException;

final class UpdateWebhookRequest
{
    public ?string $event;
    public ?string $url;
    public ?string $authorization;

    public function __construct(
        ?string $event = null,
        ?string $url = null,
        ?string $authorization = null
    ) {
        if ($url !== null && !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('If provided, the URL for the webhook must be valid.');
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