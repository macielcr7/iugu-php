<?php

declare(strict_types=1);

namespace Iugu\Application\Splits;

use Iugu\Application\Splits\Requests\CreateSplitRequest;
use Iugu\Domain\Splits\Split;
use Iugu\Infrastructure\Http\IuguHttpClient;

class CreateSplitUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param CreateSplitRequest $request
     * @return Split[]
     * @throws \Exception
     */
    public function execute(CreateSplitRequest $request): array
    {
        $response = $this->client->post('invoices/' . $request->invoice_id . '/splits', ['recipients' => $request->recipients]);
        $body = json_decode((string) $response->getBody(), true);
        // var_dump($body);

        $splits = [];
        foreach ($body as $splitData) {
            $splits[] = new Split(
                id: $splitData['id'],
                name: $splitData['name'] ?? null,
                recipient_account_id: $splitData['recipient_account_id'],
                permit_aggregated: $splitData['permit_aggregated'],
                percent: $splitData['percent'],
                cents: $splitData['cents'],
                credit_card_percent: $splitData['credit_card_percent'],
                credit_card_cents: $splitData['credit_card_cents'],
                bank_slip_percent: $splitData['bank_slip_percent'],
                bank_slip_cents: $splitData['bank_slip_cents'],
                pix_percent: $splitData['pix_percent'],
                pix_cents: $splitData['pix_cents'],
                created_at: $splitData['created_at'] ?? null,
                updated_at: $splitData['updated_at'] ?? null
            );
        }

        return $splits;
    }
} 