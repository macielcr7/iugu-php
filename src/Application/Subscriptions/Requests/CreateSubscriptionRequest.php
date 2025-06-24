<?php

declare(strict_types=1);

namespace Iugu\Application\Subscriptions\Requests;

use InvalidArgumentException;
use Iugu\Application\Common\Requests\CustomVariableRequest;

final class CreateSubscriptionRequest
{
    /**
     * @param SubscriptionSubItemRequest[]|null $subitems
     * @param CustomVariableRequest[]|null $custom_variables
     * @param array|null $splits
     */
    public function __construct(
        public readonly string $customer_id,
        public readonly ?string $plan_identifier = null,
        public readonly ?string $expires_at = null,
        public readonly ?bool $only_on_charge_success = null,
        public readonly ?string $payable_with = null,
        public readonly ?bool $credits_based = null,
        public readonly ?int $price_cents = null,
        public readonly ?int $credits_cycle = null,
        public readonly ?int $credits_min = null,
        public readonly ?array $subitems = null,
        public readonly ?array $custom_variables = null,
        public readonly ?bool $two_step = null,
        public readonly ?bool $suspend_on_invoice_expired = null,
        public readonly ?bool $only_charge_on_due_date = null,
        public readonly ?array $splits = null,
    ) {
        if (empty($customer_id)) {
            throw new InvalidArgumentException('Customer ID is required.');
        }

        if (empty($plan_identifier)) {
            throw new InvalidArgumentException('Plan identifier is required.');
        }
    }

    public function toArray(): array
    {
        $data = [
            'customer_id' => $this->customer_id,
            'plan_identifier' => $this->plan_identifier,
            'expires_at' => $this->expires_at,
        ];

        if ($this->subitems) {
            $data['subitems'] = array_map(
                fn (SubscriptionSubItemRequest $item) => $item->toArray(),
                $this->subitems
            );
        }

        if ($this->custom_variables) {
            $data['custom_variables'] = array_map(
                fn (CustomVariableRequest $cv) => $cv->toArray(),
                $this->custom_variables
            );
        }

        return array_filter($data, fn ($value) => $value !== null);
    }
} 