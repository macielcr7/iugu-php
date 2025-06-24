<?php

declare(strict_types=1);

namespace Iugu;

use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Services\CustomerService;
use Iugu\Services\DirectChargeService;
use Iugu\Services\InvoiceService;
use Iugu\Services\PlanService;
use Iugu\Services\SplitService;
use Iugu\Services\SubscriptionService;
use Iugu\Services\WebhookService;
use Iugu\Services\PaymentMethodService;
use Iugu\Services\PaymentTokenService;
use Iugu\Services\BillService;
use Iugu\Services\ApiTokenService;
use Iugu\Services\ZeroAuthService;

final class Iugu
{
    private IuguHttpClient $client;

    public function __construct(IuguHttpClient|string|null $clientOrApiToken = null)
    {
        if ($clientOrApiToken instanceof IuguHttpClient) {
            $this->client = $clientOrApiToken;
        } elseif (is_string($clientOrApiToken)) {
            $this->client = new IuguHttpClient($clientOrApiToken);
        } else {
            // Busca o token de config/env
            $apiToken = getenv('IUGU_API_TOKEN') ?: (function_exists('config') ? config('iugu.api_token') : null);
            if (!$apiToken) {
                throw new \RuntimeException('Token da API Iugu não encontrado. Configure a variável de ambiente IUGU_API_TOKEN ou config/iugu.php.');
            }
            $this->client = new IuguHttpClient($apiToken);
        }
    }

    public static function create(string $apiToken): self
    {
        return new self($apiToken);
    }

    public function invoices(): InvoiceService
    {
        return new InvoiceService($this->client);
    }

    public function customers(): CustomerService
    {
        return new CustomerService($this->client);
    }

    public function plans(): PlanService
    {
        return new PlanService($this->client);
    }

    public function subscriptions(): SubscriptionService
    {
        return new SubscriptionService($this->client);
    }

    public function splits(): SplitService
    {
        return new SplitService($this->client);
    }

    public function webhooks(): WebhookService
    {
        return new WebhookService($this->client);
    }

    public function directCharges(): DirectChargeService
    {
        return new DirectChargeService($this->client);
    }

    public function paymentMethods(): PaymentMethodService
    {
        return new PaymentMethodService($this->client);
    }

    public function paymentTokens(): PaymentTokenService
    {
        return new PaymentTokenService($this->client);
    }

    public function bills(): BillService
    {
        return new BillService($this->client);
    }

    public function apiTokens(): ApiTokenService
    {
        return new ApiTokenService($this->client);
    }

    public function zeroAuth(): ZeroAuthService
    {
        return new ZeroAuthService($this->client);
    }
}
