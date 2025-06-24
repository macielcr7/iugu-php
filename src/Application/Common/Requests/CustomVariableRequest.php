<?php

declare(strict_types=1);

namespace Iugu\Application\Common\Requests;

use InvalidArgumentException;

final class CustomVariableRequest
{
    public string $name;
    public string $value;

    public function __construct(string $name, string $value)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Custom variable name is required.');
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