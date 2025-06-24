<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\Bills\CreateBillUseCase;
use Iugu\Application\Bills\GetBillUseCase;
use Iugu\Application\Bills\ListBillsUseCase;
use Iugu\Application\Bills\CancelBillUseCase;
use Iugu\Application\Bills\Requests\CreateBillRequest;
use Iugu\Domain\Bills\Bill;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class BillService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function create(CreateBillRequest $request): Bill
    {
        return (new CreateBillUseCase($this->client))->execute($request);
    }

    public function get(string $id): Bill
    {
        return (new GetBillUseCase($this->client))->execute($id);
    }

    /**
     * @return Bill[]
     */
    public function list(): array
    {
        return (new ListBillsUseCase($this->client))->execute();
    }

    public function cancel(string $id): Bill
    {
        return (new CancelBillUseCase($this->client))->execute($id);
    }
} 