<?php

declare(strict_types=1);

namespace Iugu\Application\Common\Requests;

use InvalidArgumentException;

final class AddressRequest
{
    public string $street;
    public string $number;
    public string $city;
    public string $state;
    public string $country;
    public string $zip_code;
    public ?string $district;
    public ?string $complement;

    public function __construct(
        string $street,
        string $number,
        string $city,
        string $state,
        string $country,
        string $zip_code,
        ?string $district = null,
        ?string $complement = null
    ) {
        if (empty($street)) {
            throw new InvalidArgumentException('Street is required.');
        }
        if (empty($zip_code)) {
            throw new InvalidArgumentException('Zip code is required.');
        }

        $this->street = $street;
        $this->number = $number;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->zip_code = $zip_code;
        $this->district = $district;
        $this->complement = $complement;
    }

    public function toArray(): array
    {
        return array_filter([
            'street' => $this->street,
            'number' => $this->number,
            'district' => $this->district,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zip_code' => $this->zip_code,
            'complement' => $this->complement,
        ], fn ($value) => $value !== null);
    }
} 