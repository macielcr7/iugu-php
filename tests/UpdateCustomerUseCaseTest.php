<?php

declare(strict_types=1);

use Iugu\Application\Customers\Requests\UpdateCustomerRequest;
use Iugu\Domain\Customers\Customer;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class UpdateCustomerUseCaseTest extends TestCase
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

    public function testExecuteReturnsUpdatedCustomer(): void
    {
        $responseBody = json_encode([
            'id' => 'c3',
            'email' => 'atualizado@exemplo.com',
            'name' => 'Atualizado',
            'cpf_cnpj' => '11122233344',
            'notes' => 'Alterado',
            'phone_prefix' => '31',
            'phone' => '777777777',
            'cc_emails' => null,
            'address' => null,
            'custom_variables' => [],
            'created_at' => '2023-01-03T00:00:00-03:00',
            'updated_at' => '2023-01-03T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('put')->willReturn($mockResponse);

        $updateCustomerRequest = new UpdateCustomerRequest(
            email: 'atualizado@exemplo.com',
            name: 'Atualizado',
            cpf_cnpj: '11122233344',
            notes: 'Alterado'
        );

        $customer = $this->iugu->customers()->update('c3', $updateCustomerRequest);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('c3', $customer->id);
        $this->assertEquals('Atualizado', $customer->name);
        $this->assertEquals('11122233344', $customer->cpf_cnpj);
        $this->assertEquals('Alterado', $customer->notes);
    }
} 