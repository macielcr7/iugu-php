<?php

declare(strict_types=1);

namespace Iugu\Application\Plans\Requests;

use InvalidArgumentException;

final class FeatureRequest
{
    public string $name;
    public int $value;

    public function __construct(string $name, int $value)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Feature name is required.');
        }

        $this->name = $name;
        $this->value = $value;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
} 