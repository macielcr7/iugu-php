<?php

declare(strict_types=1);

namespace Iugu\Domain\ApiTokens;

class ApiToken
{
    private string $id;
    private string $description;
    private string $token;
    private string $createdAt;
    private ?string $apiType;

    public function __construct(
        string $id,
        string $description,
        string $token,
        string $createdAt,
        ?string $apiType = null
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->token = $token;
        $this->createdAt = $createdAt;
        $this->apiType = $apiType;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getApiType(): ?string
    {
        return $this->apiType;
    }
} 