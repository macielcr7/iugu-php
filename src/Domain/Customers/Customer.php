<?php

declare(strict_types=1);

namespace Iugu\Domain\Customers;

use Iugu\Domain\Common\Address;
use Iugu\Domain\Common\CustomVariable;

final class Customer
{
    /**
     * @param CustomVariable[] $custom_variables
     */
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly string $name,
        public readonly ?string $notes = null,
        public readonly ?string $cpf_cnpj = null,
        public readonly ?string $cc_emails = null,
        public readonly ?string $phone_prefix = null,
        public readonly ?string $phone = null,
        public readonly ?Address $address = null,
        public readonly ?array $custom_variables = [],
        public readonly ?string $created_at = null,
        public readonly ?string $updated_at = null,
    ) {
    }
} 