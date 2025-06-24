<?php

declare(strict_types=1);

use Iugu\Domain\Customers\Customer;
use Iugu\Iugu;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ListCustomersUseCaseTest extends TestCase
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

    public function testExecuteReturnsArrayOfCustomers(): void
    {
        $responseBody = json_encode([
            'items' => [
                [
                    'id' => 'c1',
                    'email' => 'a@b.com',
                    'name' => 'A',
                    'cpf_cnpj' => '1',
                    'notes' => 'Primeiro',
                    'phone_prefix' => '11',
                    'phone' => '111111111',
                    'cc_emails' => null,
                    'address' => null,
                    'custom_variables' => [],
                    'created_at' => '2023-01-01T00:00:00-03:00',
                    'updated_at' => '2023-01-01T00:00:00-03:00',
                ],
                [
                    'id' => 'c2',
                    'email' => 'b@c.com',
                    'name' => 'B',
                    'cpf_cnpj' => '2',
                    'notes' => 'Segundo',
                    'phone_prefix' => '22',
                    'phone' => '222222222',
                    'cc_emails' => null,
                    'address' => null,
                    'custom_variables' => [],
                    'created_at' => '2023-01-02T00:00:00-03:00',
                    'updated_at' => '2023-01-02T00:00:00-03:00',
                ]
            ]
        ]);

        $mockStream = $this->createMock(StreamInterface::class);
        $mockStream->method('getContents')->willReturn($responseBody);
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('getBody')->willReturn($mockStream);
        $this->mockClient->method('get')->willReturn($mockResponse);

        $customers = $this->iugu->customers()->list();

        $this->assertIsArray($customers);
        $this->assertCount(2, $customers);
        $this->assertInstanceOf(Customer::class, $customers[0]);
        $this->assertEquals('c1', $customers[0]->id);
        $this->assertEquals('c2', $customers[1]->id);
    }
} 