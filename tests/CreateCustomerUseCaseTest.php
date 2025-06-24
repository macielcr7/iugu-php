<?php

declare(strict_types=1);

use Iugu\Application\Customers\Requests\CreateCustomerRequest;
use Iugu\Domain\Customers\Customer;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CreateCustomerUseCaseTest extends TestCase
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
            'id' => 'c1',
            'email' => 'cliente@exemplo.com',
            'name' => 'Cliente Teste',
            'cpf_cnpj' => '12345678900',
            'notes' => 'Observação',
            'phone_prefix' => '11',
            'phone' => '999999999',
            'cc_emails' => null,
            'address' => null,
            'custom_variables' => [],
            'created_at' => '2023-01-01T00:00:00-03:00',
            'updated_at' => '2023-01-01T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('post')->willReturn($mockResponse);

        $createCustomerRequest = new CreateCustomerRequest(
            email: 'cliente@exemplo.com',
            name: 'Cliente Teste',
            cpf_cnpj: '12345678900',
            notes: 'Observação'
        );

        $customer = $this->iugu->customers()->create($createCustomerRequest);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('c1', $customer->id);
        $this->assertEquals('cliente@exemplo.com', $customer->email);
        $this->assertEquals('Cliente Teste', $customer->name);
        $this->assertEquals('12345678900', $customer->cpf_cnpj);
        $this->assertEquals('Observação', $customer->notes);
    }
} 