<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\Customers\CreateCustomerUseCase;
use Iugu\Application\Customers\DeleteCustomerUseCase;
use Iugu\Application\Customers\GetCustomerUseCase;
use Iugu\Application\Customers\ListCustomersUseCase;
use Iugu\Application\Customers\UpdateCustomerUseCase;
use Iugu\Application\Customers\Requests\CreateCustomerRequest;
use Iugu\Application\Customers\Requests\UpdateCustomerRequest;
use Iugu\Domain\Customers\Customer;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class CustomerService
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient $client)
    {
        $this->client = $client;
    }

    public function create(CreateCustomerRequest $request): Customer
    {
        return (new CreateCustomerUseCase($this->client))->execute($request);
    }

    public function get(string $id): Customer
    {
        return (new GetCustomerUseCase($this->client))->execute($id);
    }

    /**
     * @return Customer[]
     */
    public function list(): array
    {
        return (new ListCustomersUseCase($this->client))->execute();
    }

    public function update(string $id, UpdateCustomerRequest $request): Customer
    {
        return (new UpdateCustomerUseCase($this->client))->execute($id, $request);
    }

    public function delete(string $id): Customer
    {
        return (new DeleteCustomerUseCase($this->client))->execute($id);
    }
} 