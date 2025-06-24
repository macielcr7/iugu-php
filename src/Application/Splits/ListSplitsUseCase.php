<?php

declare(strict_types=1);

namespace Iugu\Application\Splits;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Splits\Split;

class ListSplitsUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @return Split[]
     * @throws \Exception
     */
    public function execute(): array
    {
        $response = $this->client->get('splits');
        $body = json_decode((string) $response->getBody(), true);
        $items = $body['items'] ?? [];
        $splits = [];
        foreach ($items as $item) {
            $splits[] = new Split(
                id: $item['id'],
                name: $item['name'] ?? null,
                recipient_account_id: $item['recipient_account_id'],
                permit_aggregated: $item['permit_aggregated'],
                percent: $item['percent'],
                cents: $item['cents'],
                credit_card_percent: $item['credit_card_percent'],
                credit_card_cents: $item['credit_card_cents'],
                bank_slip_percent: $item['bank_slip_percent'],
                bank_slip_cents: $item['bank_slip_cents'],
                pix_percent: $item['pix_percent'],
                pix_cents: $item['pix_cents'],
                created_at: $item['created_at'] ?? null,
                updated_at: $item['updated_at'] ?? null
            );
        }
        return $splits;
    }
} 