<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Customers\CreateCustomerUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Customers\Customer;
use Psr\Http\Message\ResponseInterface;

class CreateCustomerUseCaseTest extends TestCase
{
    public function testExecuteReturnsCustomer(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'c1',
            'email' => 'cliente@exemplo.com',
            'name' => 'Cliente Teste',
            'cpf_cnpj' => '12345678900',
            'notes' => 'Observação',
        ]));
        $mockClient->method('post')->willReturn($mockResponse);

        $useCase = new CreateCustomerUseCase($mockClient);
        $customer = $useCase->execute([
            'email' => 'cliente@exemplo.com',
            'name' => 'Cliente Teste',
            'cpf_cnpj' => '12345678900',
            'notes' => 'Observação',
        ]);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('c1', $customer->id);
        $this->assertEquals('cliente@exemplo.com', $customer->email);
        $this->assertEquals('Cliente Teste', $customer->name);
        $this->assertEquals('12345678900', $customer->cpfCnpj);
        $this->assertEquals('Observação', $customer->notes);
    }
} 