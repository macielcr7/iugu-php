<?php

declare(strict_types=1);

namespace Iugu\Services;

use Iugu\Application\PaymentMethods\CreatePaymentMethodUseCase;
use Iugu\Application\PaymentMethods\DeletePaymentMethodUseCase;
use Iugu\Application\PaymentMethods\GetPaymentMethodUseCase;
use Iugu\Application\PaymentMethods\ListPaymentMethodsUseCase;
use Iugu\Application\PaymentMethods\UpdatePaymentMethodUseCase;
use Iugu\Application\PaymentMethods\Requests\CreatePaymentMethodRequest;
use Iugu\Application\PaymentMethods\Requests\UpdatePaymentMethodRequest;
use Iugu\Domain\PaymentMethods\PaymentMethod;
use Iugu\Infrastructure\Http\IuguHttpClient;

final class PaymentMethodService
{
    public function __construct(private IuguHttpClient $client) {}

    public function create(string $customerId, CreatePaymentMethodRequest $request): PaymentMethod
    {
        return (new CreatePaymentMethodUseCase($this->client))->execute($customerId, $request);
    }

    public function get(string $customerId, string $paymentMethodId): PaymentMethod
    {
        return (new GetPaymentMethodUseCase($this->client))->execute($customerId, $paymentMethodId);
    }

    /** @return PaymentMethod[] */
    public function list(string $customerId): array
    {
        return (new ListPaymentMethodsUseCase($this->client))->execute($customerId);
    }

    public function update(string $customerId, string $paymentMethodId, UpdatePaymentMethodRequest $request): PaymentMethod
    {
        return (new UpdatePaymentMethodUseCase($this->client))->execute($customerId, $paymentMethodId, $request);
    }

    public function delete(string $customerId, string $paymentMethodId): PaymentMethod
    {
        return (new DeletePaymentMethodUseCase($this->client))->execute($customerId, $paymentMethodId);
    }
} 