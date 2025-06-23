<?php

declare(strict_types=1);

namespace Iugu\Application\Webhooks;

use Iugu\Infrastructure\Http\IuguHttpClient;

class ListEventsUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @return string[]
     * @throws \Exception
     */
    public function execute(): array
    {
        $response = $this->client->get('triggers/events');
        $body = json_decode((string) $response->getBody(), true);
        return $body['events'] ?? [];
    }
} 