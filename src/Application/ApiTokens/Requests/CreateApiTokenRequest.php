<?php

declare(strict_types=1);

namespace Iugu\Application\ApiTokens\Requests;

final class CreateApiTokenRequest
{
    public function __construct(
        public readonly string $api_type,
        public readonly string $description
    ) {}

    public function toArray(): array
    {
        return [
            'api_type' => $this->api_type,
            'description' => $this->description,
        ];
    }
} 