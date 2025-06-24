<?php

declare(strict_types=1);

namespace Iugu\Domain\Common;

class Address
{
    public function __construct(
        public readonly string $street,
        public readonly string $number,
        public readonly string $city,
        public readonly string $state,
        public readonly string $country,
        public readonly string $zip_code,
        public readonly ?string $district,
        public readonly ?string $complement
    ) {}
} 