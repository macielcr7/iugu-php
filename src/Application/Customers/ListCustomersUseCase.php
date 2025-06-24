<?php

declare(strict_types=1);

namespace Iugu\Application\Customers;

use Iugu\Domain\Common\Address;
use Iugu\Domain\Common\CustomVariable;
use Iugu\Domain\Customers\Customer;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class ListCustomersUseCase
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return Customer[]
     */
    public function execute(array $filters = []): array
    {
        $response = $this->client->get('/v1/customers', $filters);
        $body = json_decode($response->getBody()->getContents());

        return array_map(function ($item) {
            $customVariables = [];
            if (!empty($item->custom_variables)) {
                $customVariables = array_map(
                    static fn ($cv) => new CustomVariable(
                        name: $cv->name,
                        value: $cv->value
                    ),
                    $item->custom_variables
                );
            }

            $address = null;
            if (isset($item->address)) {
                $address = new Address(
                    street: $item->address->street ?? null,
                    number: $item->address->number ?? null,
                    city: $item->address->city ?? null,
                    state: $item->address->state ?? null,
                    country: $item->address->country ?? null,
                    zip_code: $item->address->zip_code ?? null,
                    district: $item->address->district ?? null,
                    complement: $item->address->complement ?? null
                );
            }

            return new Customer(
                id: $item->id,
                email: $item->email,
                name: $item->name,
                notes: $item->notes ?? null,
                cpf_cnpj: $item->cpf_cnpj ?? null,
                cc_emails: $item->cc_emails ?? null,
                phone_prefix: $item->phone_prefix ?? null,
                phone: $item->phone ?? null,
                address: $address,
                custom_variables: $customVariables,
                created_at: $item->created_at,
                updated_at: $item->updated_at
            );
        }, $body->items);
    }
} 