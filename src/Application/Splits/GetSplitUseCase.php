<?php

declare(strict_types=1);

namespace Iugu\Application\Splits;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Splits\Split;

class GetSplitUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param string $id
     * @return Split
     * @throws \Exception
     */
    public function execute(string $id): Split
    {
        $response = $this->client->get('splits/' . $id);
        $body = json_decode((string) $response->getBody(), true);

        return new Split(
            $body['id'] ?? null,
            $body['recipient_account_id'] ?? '',
            $body['cents'] ?? null,
            $body['percent'] ?? null,
            $body['type'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 