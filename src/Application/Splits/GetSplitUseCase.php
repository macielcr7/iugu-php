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
            id: $body['id'],
            name: $body['name'] ?? null,
            recipient_account_id: $body['recipient_account_id'],
            permit_aggregated: $body['permit_aggregated'],
            percent: $body['percent'],
            cents: $body['cents'],
            credit_card_percent: $body['credit_card_percent'],
            credit_card_cents: $body['credit_card_cents'],
            bank_slip_percent: $body['bank_slip_percent'],
            bank_slip_cents: $body['bank_slip_cents'],
            pix_percent: $body['pix_percent'],
            pix_cents: $body['pix_cents'],
            created_at: $body['created_at'] ?? null,
            updated_at: $body['updated_at'] ?? null
        );
    }
} 