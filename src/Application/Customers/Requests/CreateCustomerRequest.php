<?php

declare(strict_types=1);

namespace Iugu\Application\Customers\Requests;

use Iugu\Application\Common\Requests\AddressRequest;
use Iugu\Application\Common\Requests\CustomVariableRequest;

final class CreateCustomerRequest
{
    /**
     * @param CustomVariableRequest[]|null $custom_variables
     */
    public function __construct(
        public readonly string $email,
        public readonly string $name,
        public readonly ?string $cpf_cnpj = null,
        public readonly ?string $notes = null,
        public readonly ?string $phone = null,
        public readonly ?string $phone_prefix = null,
        public readonly ?AddressRequest $address = null,
        public readonly ?array $custom_variables = null
    ) {
    }
} 