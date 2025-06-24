<?php

declare(strict_types=1);

namespace Iugu\Application\Common\Requests;

use InvalidArgumentException;

final class PayerRequest
{
    public string $name;
    public string $cpf_cnpj;
    public AddressRequest $address;
    public ?string $phone_prefix;
    public ?string $phone;
    public ?string $email;

    public function __construct(
        string $name,
        string $cpf_cnpj,
        AddressRequest $address,
        ?string $phone_prefix = null,
        ?string $phone = null,
        ?string $email = null
    ) {
        if (empty($name)) {
            throw new InvalidArgumentException('Payer name is required.');
        }
        if (empty($cpf_cnpj)) {
            throw new InvalidArgumentException('Payer CPF/CNPJ is required.');
        }

        $this->name = $name;
        $this->cpf_cnpj = $cpf_cnpj;
        $this->address = $address;
        $this->phone_prefix = $phone_prefix;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'cpf_cnpj' => $this->cpf_cnpj,
            'address' => $this->address->toArray(),
            'phone_prefix' => $this->phone_prefix,
            'phone' => $this->phone,
            'email' => $this->email,
        ], fn ($value) => $value !== null);
    }
} 