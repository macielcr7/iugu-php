<?php

declare(strict_types=1);

use Iugu\Domain\Customers\Customer;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetCustomerUseCaseTest extends TestCase
{
    private Iugu $iugu;
    private $mockClient;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var IuguHttpClient&MockObject $mockClient */
        $mockClient = $this->createMock(IuguHttpClient::class);
        $this->mockClient = $mockClient;
        $this->iugu = new Iugu($this->mockClient);
    }

    public function testExecuteReturnsCustomer(): void
    {
        $responseBody = json_encode([
            'id' => 'c2',
            'email' => 'cliente2@exemplo.com',
            'name' => 'Cliente Dois',
            'cpf_cnpj' => '98765432100',
            'notes' => 'VIP',
            'phone_prefix' => '21',
            'phone' => '888888888',
            'cc_emails' => null,
            'address' => null,
            'custom_variables' => [],
            'created_at' => '2023-01-02T00:00:00-03:00',
            'updated_at' => '2023-01-02T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $customer = $this->iugu->customers()->get('c2');

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('c2', $customer->id);
        $this->assertEquals('cliente2@exemplo.com', $customer->email);
        $this->assertEquals('Cliente Dois', $customer->name);
        $this->assertEquals('98765432100', $customer->cpf_cnpj);
        $this->assertEquals('VIP', $customer->notes);
    }
} 