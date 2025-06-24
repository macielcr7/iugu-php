<?php

declare(strict_types=1);

namespace Iugu\Application\Subscriptions\Requests;

final class UpdateSubscriptionRequest
{
    public ?string $plan_identifier;
    public ?string $expires_at;
    public ?array $custom_variables;

    public function __construct(
        ?string $plan_identifier = null,
        ?string $expires_at = null,
        ?array $custom_variables = null
    ) {
        $this->plan_identifier = $plan_identifier;
        $this->expires_at = $expires_at;
        $this->custom_variables = $custom_variables;
    }

    public function toArray(): array
    {
        return array_filter([
            'plan_identifier' => $this->plan_identifier,
            'expires_at' => $this->expires_at,
            'custom_variables' => $this->custom_variables,
        ], fn ($value) => $value !== null);
    }
} 