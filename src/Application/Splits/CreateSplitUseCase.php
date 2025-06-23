<?php

declare(strict_types=1);

namespace Iugu\Application\Splits;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Splits\Split;

class CreateSplitUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param array $data
     * @return Split
     * @throws \Exception
     */
    public function execute(array $data): Split
    {
        $response = $this->client->post('splits', $data);
        $body = json_decode((string) $response->getBody(), true);

        return new Split(
            $body['id'] ?? null,
            $body['recipient_account_id'] ?? $data['recipient_account_id'],
            $body['cents'] ?? $data['cents'] ?? null,
            $body['percent'] ?? $data['percent'] ?? null,
            $body['type'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
            $body['data'] ?? null,
        );
    }
} 