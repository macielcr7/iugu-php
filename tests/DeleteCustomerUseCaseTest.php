<?php

declare(strict_types=1);

use Iugu\Domain\Customers\Customer;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class DeleteCustomerUseCaseTest extends TestCase
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

    public function testExecuteReturnsDeletedCustomer(): void
    {
        $responseBody = json_encode([
            'id' => 'c4',
            'email' => 'deletado@exemplo.com',
            'name' => 'Deletado',
            'cpf_cnpj' => '00011122233',
            'notes' => 'Removido',
            'phone_prefix' => '41',
            'phone' => '666666666',
            'cc_emails' => null,
            'address' => null,
            'custom_variables' => [],
            'created_at' => '2023-01-04T00:00:00-03:00',
            'updated_at' => '2023-01-04T00:00:00-03:00',
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('delete')->willReturn($mockResponse);

        $customer = $this->iugu->customers()->delete('c4');

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertEquals('c4', $customer->id);
        $this->assertEquals('deletado@exemplo.com', $customer->email);
        $this->assertEquals('Deletado', $customer->name);
        $this->assertEquals('00011122233', $customer->cpf_cnpj);
        $this->assertEquals('Removido', $customer->notes);
    }
} 