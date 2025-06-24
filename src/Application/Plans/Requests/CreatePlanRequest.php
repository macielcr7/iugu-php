<?php

declare(strict_types=1);

namespace Iugu\Application\Plans\Requests;

use InvalidArgumentException;

final class CreatePlanRequest
{
    public string $name;
    public string $identifier;
    public int $interval;
    public string $interval_type;
    /** @var PlanPriceRequest[] */
    public array $prices;
    /** @var FeatureRequest[]|null */
    public ?array $features;

    /**
     * @param string $name
     * @param string $identifier
     * @param int $interval
     * @param string $interval_type
     * @param PlanPriceRequest[] $prices
     * @param FeatureRequest[]|null $features
     */
    public function __construct(
        string $name,
        string $identifier,
        int $interval,
        string $interval_type,
        array $prices,
        ?array $features = null
    ) {
        if (empty($name)) {
            throw new InvalidArgumentException('Plan name is required.');
        }

        if (empty($identifier)) {
            throw new InvalidArgumentException('Plan identifier is required.');
        }

        if ($interval <= 0) {
            throw new InvalidArgumentException('Interval must be greater than zero.');
        }

        if (!in_array($interval_type, ['weeks', 'months'])) {
            throw new InvalidArgumentException('Interval type must be "weeks" or "months".');
        }

        if (empty($prices)) {
            throw new InvalidArgumentException('At least one price is required.');
        }

        $this->name = $name;
        $this->identifier = $identifier;
        $this->interval = $interval;
        $this->interval_type = $interval_type;
        $this->prices = $prices;
        $this->features = $features;
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'identifier' => $this->identifier,
            'interval' => $this->interval,
            'interval_type' => $this->interval_type,
            'prices' => array_map(fn (PlanPriceRequest $price) => $price->toArray(), $this->prices),
        ];

        if ($this->features) {
            $data['features'] = array_map(fn (FeatureRequest $feature) => $feature->toArray(), $this->features);
        }

        return array_filter($data, fn ($value) => $value !== null);
    }
} 