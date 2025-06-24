<?php

declare(strict_types=1);

namespace Iugu\Application\Bills\Requests;

final class CreateBillRequest
{
    public function __construct(
        public readonly string $email,
        public readonly string $due_date,
        public readonly array $items,
        public readonly ?array $custom_variables = null
    ) {}

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'due_date' => $this->due_date,
            'items' => $this->items,
            'custom_variables' => $this->custom_variables,
        ];
    }

    public function getEmail(): string { return $this->email; }
    public function getDueDate(): string { return $this->due_date; }
    public function getItems(): array { return $this->items; }
} 