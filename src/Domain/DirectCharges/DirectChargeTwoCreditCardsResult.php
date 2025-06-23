<?php

declare(strict_types=1);

namespace Iugu\Domain\DirectCharges;

class DirectChargeTwoCreditCardsResult
{
    private string $id;
    private string $status;
    private ?array $errors;
    private ?array $rawResponse;

    public function __construct(string $id, string $status, ?array $errors = null, ?array $rawResponse = null)
    {
        $this->id = $id;
        $this->status = $status;
        $this->errors = $errors;
        $this->rawResponse = $rawResponse;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function getRawResponse(): ?array
    {
        return $this->rawResponse;
    }
} 