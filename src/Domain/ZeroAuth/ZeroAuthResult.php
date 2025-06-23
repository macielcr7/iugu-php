<?php

declare(strict_types=1);

namespace Iugu\Domain\ZeroAuth;

class ZeroAuthResult
{
    private string $status;
    private ?string $message;
    private ?array $rawResponse;

    public function __construct(string $status, ?string $message = null, ?array $rawResponse = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->rawResponse = $rawResponse;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getRawResponse(): ?array
    {
        return $this->rawResponse;
    }
} 