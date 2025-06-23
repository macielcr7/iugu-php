<?php

declare(strict_types=1);

namespace Iugu\Domain\PaymentTokens;

class PaymentToken
{
    private string $id;
    private string $method;
    private bool $test;
    private string $token;
    private ?string $extraInfo;

    public function __construct(
        string $id,
        string $method,
        bool $test,
        string $token,
        ?string $extraInfo = null
    ) {
        $this->id = $id;
        $this->method = $method;
        $this->test = $test;
        $this->token = $token;
        $this->extraInfo = $extraInfo;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function isTest(): bool
    {
        return $this->test;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExtraInfo(): ?string
    {
        return $this->extraInfo;
    }
} 