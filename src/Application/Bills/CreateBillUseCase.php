<?php

declare(strict_types=1);

namespace Iugu\Application\Bills;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Bills\Bill;
use Iugu\Application\Bills\Requests\CreateBillRequest;

class CreateBillUseCase
{
    public function __construct(private IuguHttpClient $client) {}

    /**
     * @param CreateBillRequest $request
     * @return Bill
     * @throws \Exception
     */
    public function execute(CreateBillRequest $request): Bill
    {
        $response = $this->client->post('bills', $request->toArray());
        $body = json_decode((string) $response->getBody(), true);

        return new Bill(
            $body['id'] ?? null,
            $body['email'] ?? $request->getEmail(),
            $body['due_date'] ?? $request->getDueDate(),
            $body['items'] ?? $request->getItems(),
            $body['status'] ?? null,
            $body['custom_variables'] ?? null,
            $body['created_at'] ?? null,
            $body['updated_at'] ?? null,
        );
    }
} 