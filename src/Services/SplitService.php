<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\Splits\CreateSplitUseCase;
use Iugu\Application\Splits\DeleteSplitUseCase;
use Iugu\Application\Splits\GetSplitUseCase;
use Iugu\Application\Splits\ListInvoiceSplitsUseCase;
use Iugu\Application\Splits\ListSplitsUseCase;
use Iugu\Application\Splits\Requests\CreateSplitRequest;
use Iugu\Domain\Splits\Split;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class SplitService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return Split[]
     */
    public function create(CreateSplitRequest $request): array
    {
        return (new CreateSplitUseCase($this->client))->execute($request);
    }

    public function get(string $id): Split
    {
        return (new GetSplitUseCase($this->client))->execute($id);
    }

    /**
     * @return Split[]
     */
    public function list(): array
    {
        return (new ListSplitsUseCase($this->client))->execute();
    }

    /**
     * @return Split[]
     */
    public function listFromInvoice(string $invoiceId): array
    {
        return (new ListInvoiceSplitsUseCase($this->client))->execute($invoiceId);
    }

    public function delete(string $id): Split
    {
        return (new DeleteSplitUseCase($this->client))->execute($id);
    }
}