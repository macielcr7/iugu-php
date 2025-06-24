<?php

declare(strict_types=1);

namespace Iugu\Domain\Subscriptions;

use Iugu\Domain\Common\CustomVariable;

class Subscription
{
    /**
     * @param CustomVariable[]|null $custom_variables
     * @param SubscriptionSubItem[]|null $subitems
     */
    public function __construct(
        public readonly ?string $id,
        public readonly ?bool $suspended,
        public readonly ?string $plan_identifier,
        public readonly ?string $customer_id,
        public readonly ?string $expires_at,
        public readonly ?string $created_at,
        public readonly ?string $updated_at,
        public readonly ?int $cycles_count,
        public readonly ?bool $active,
        public readonly ?array $custom_variables = null,
        public readonly ?array $subitems = null
    ) {}
} 