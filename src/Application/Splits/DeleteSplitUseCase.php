<?php

declare(strict_types=1);

namespace Iugu\Application\Splits;

use Iugu\Domain\Splits\Split;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class DeleteSplitUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function execute(string $id): Split
    {
        $response = $this->client->delete("/v1/splits/$id");
        $body = json_decode((string) $response->getBody());

        return new Split(
            id: $body->id,
            name: $body->name ?? null,
            recipient_account_id: $body->recipient_account_id,
            permit_aggregated: $body->permit_aggregated,
            percent: $body->percent ?? null,
            cents: $body->cents ?? null,
            credit_card_percent: $body->credit_card_percent ?? null,
            credit_card_cents: $body->credit_card_cents ?? null,
            bank_slip_percent: $body->bank_slip_percent ?? null,
            bank_slip_cents: $body->bank_slip_cents ?? null,
            pix_percent: $body->pix_percent ?? null,
            pix_cents: $body->pix_cents ?? null,
            created_at: $body->created_at,
            updated_at: $body->updated_at
        );
    }
} 