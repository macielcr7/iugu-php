<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iugu\Application\Customers\ListCustomersUseCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Domain\Customers\Customer;
use Psr\Http\Message\ResponseInterface;

class ListCustomersUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfCustomers(): void
    {
        $mockClient = $this->createMock(IuguHttpClient::class);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn(json_encode([
            'items' => [
                [
                    'id' => 'c1',
                    'email' => 'a@b.com',
                    'name' => 'A',
                    'cpf_cnpj' => '1',
                ],
                [
                    'id' => 'c2',
                    'email' => 'b@c.com',
                    'name' => 'B',
                    'cpf_cnpj' => '2',
                ]
            ]
        ]));
        $mockClient->method('get')->willReturn($mockResponse);

        $useCase = new ListCustomersUseCase($mockClient);
        $customers = $useCase->execute();

        $this->assertIsArray($customers);
        $this->assertCount(2, $customers);
        $this->assertInstanceOf(Customer::class, $customers[0]);
        $this->assertEquals('c1', $customers[0]->id);
        $this->assertEquals('c2', $customers[1]->id);
    }
} 