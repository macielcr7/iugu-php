<?php

declare(strict_types=1);

namespace Iugu\Application\Customers;

use Iugu\Application\Customers\Requests\CreateCustomerRequest;
use Iugu\Domain\Common\Address;
use Iugu\Domain\Common\CustomVariable;
use Iugu\Domain\Customers\Customer;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class CreateCustomerUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function execute(CreateCustomerRequest $request): Customer
    {
        $response = $this->client->post('/v1/customers', $request);
        $body = json_decode($response->getBody()->getContents());

        $customVariables = [];
        if (!empty($body->custom_variables)) {
            $customVariables = array_map(
                static fn ($cv) => new CustomVariable(
                    name: $cv->name,
                    value: $cv->value
                ),
                $body->custom_variables
            );
        }

        $address = null;
        if (isset($body->address)) {
            $address = new Address(
                street: $body->address->street,
                number: $body->address->number,
                city: $body->address->city,
                state: $body->address->state,
                country: $body->address->country,
                zip_code: $body->address->zip_code,
                district: $body->address->district,
                complement: $body->address->complement
            );
        }

        return new Customer(
            id: $body->id,
            email: $body->email,
            name: $body->name,
            notes: $body->notes,
            created_at: $body->created_at,
            updated_at: $body->updated_at,
            cpf_cnpj: $body->cpf_cnpj,
            phone: $body->phone,
            phone_prefix: $body->phone_prefix,
            address: $address,
            custom_variables: $customVariables,
        );
    }
} 