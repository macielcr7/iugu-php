<?php

declare(strict_types=1);

namespace Iugu\Application\Customers;

use Iugu\Domain\Common\Address;
use Iugu\Domain\Common\CustomVariable;
use Iugu\Domain\Customers\Customer;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class DeleteCustomerUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function execute(string $id): Customer
    {
        $response = $this->client->delete("/v1/customers/$id");
        $body = json_decode($response->getBody()->getContents());

        $customVariables = [];
        if (!empty($body->custom_variables)) {
            $customVariables = array_map(function ($cv) {
                return new CustomVariable(
                    name: $cv->name,
                    value: $cv->value,
                );
            }, $body->custom_variables);
        }

        $address = null;
        if (isset($body->address)) {
            $address = new Address(
                street: $body->address->street ?? null,
                number: $body->address->number ?? null,
                city: $body->address->city ?? null,
                state: $body->address->state ?? null,
                country: $body->address->country ?? null,
                zip_code: $body->address->zip_code ?? null,
                district: $body->address->district ?? null,
                complement: $body->address->complement ?? null
            );
        }

        return new Customer(
            id: $body->id,
            email: $body->email,
            name: $body->name,
            notes: $body->notes ?? null,
            cpf_cnpj: $body->cpf_cnpj ?? null,
            cc_emails: $body->cc_emails ?? null,
            phone_prefix: $body->phone_prefix ?? null,
            phone: $body->phone ?? null,
            address: $address,
            custom_variables: $customVariables,
            created_at: $body->created_at,
            updated_at: $body->updated_at
        );
    }
} 