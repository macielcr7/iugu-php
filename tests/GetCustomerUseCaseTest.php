<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Customers\GetCustomerUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Customers\Customer;
use Psr\Http\Message\ResponseInterface;

class GetCustomerUseCaseTest extends TestCase
{
    public function testExecuteReturnsCustomer(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'id' => 'c2',
            'email' => 'cliente2@exemplo.com',
            'name' => 'Cliente Dois',
            'cpf_cnpj' => '98765432100',
            'notes' => 'VIP',
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new GetCustomerUseCase($mockClient);
        $customer = $useCase->execute('c2');

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('c2', $customer->id);
        $this->assertEquals('cliente2@exemplo.com', $customer->email);
        $this->assertEquals('Cliente Dois', $customer->name);
        $this->assertEquals('98765432100', $customer->cpfCnpj);
        $this->assertEquals('VIP', $customer->notes);
    }
} 