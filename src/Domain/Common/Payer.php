<?php

declare(strict_types=1);

namespace Iugu\Domain\Common;

class Payer
{
    /**
     * @param Address $address
     */
    public function __construct(
        public readonly string $name,
        public readonly string $cpf_cnpj,
        public readonly Address $address,
        public readonly ?string $phone_prefix = null,
        public readonly ?string $phone = null,
        public readonly ?string $email = null
    ) {}
} 