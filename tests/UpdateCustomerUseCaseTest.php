<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Customers\UpdateCustomerUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Customers\Customer;
use Psr\Http\Message\ResponseInterface;

class UpdateCustomerUseCaseTest extends TestCase
{
    public function testExecuteReturnsUpdatedCustomer(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'c3',
            'email' => 'atualizado@exemplo.com',
            'name' => 'Atualizado',
            'cpf_cnpj' => '11122233344',
            'notes' => 'Alterado',
        ]));
        $mockClient->method('put')->willReturn($mockResponse);

        $useCase = new UpdateCustomerUseCase($mockClient);
        $customer = $useCase->execute('c3', [
            'email' => 'atualizado@exemplo.com',
            'name' => 'Atualizado',
            'cpf_cnpj' => '11122233344',
            'notes' => 'Alterado',
        ]);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('c3', $customer->id);
        $this->assertEquals('Atualizado', $customer->name);
        $this->assertEquals('11122233344', $customer->cpfCnpj);
        $this->assertEquals('Alterado', $customer->notes);
    }
} 