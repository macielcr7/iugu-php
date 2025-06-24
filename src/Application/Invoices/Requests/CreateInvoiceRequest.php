<?php

declare(strict_types=1);

namespace Iugu\Application\Invoices\Requests;

use InvalidArgumentException;
use Iugu\Application\Common\Requests\PayerRequest;

final class CreateInvoiceRequest
{
    public string $email;
    public string $due_date;
    /** @var InvoiceItemRequest[] */
    public array $items;
    public ?PayerRequest $payer;
    public ?array $custom_variables;

    /**
     * @param string $email
     * @param string $due_date
     * @param InvoiceItemRequest[] $items
     * @param PayerRequest|null $payer
     * @param array|null $custom_variables
     */
    public function __construct(
        string $email,
        string $due_date,
        array $items,
        ?PayerRequest $payer = null,
        ?array $custom_variables = null
    ) {
        if (empty($email)) {
            throw new InvalidArgumentException('Email is required.');
        }
        if (empty($due_date)) {
            throw new InvalidArgumentException('Due date is required.');
        }
        if (empty($items)) {
            throw new InvalidArgumentException('Items are required.');
        }

        $this->email = $email;
        $this->due_date = $due_date;
        $this->items = $items;
        $this->payer = $payer;
        $this->custom_variables = $custom_variables;
    }

    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email,
            'due_date' => $this->due_date,
            'items' => array_map(fn (InvoiceItemRequest $item) => $item->toArray(), $this->items),
            'payer' => $this->payer ? $this->payer->toArray() : null,
            'custom_variables' => $this->custom_variables,
        ], fn ($value) => $value !== null);
    }
} 