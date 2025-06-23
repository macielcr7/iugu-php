# Exemplos de Uso - Integração Iugu PHP

Este diretório contém exemplos práticos de uso do package de integração com a API da Iugu, prontos para rodar via CLI ou serem adaptados para controllers/services do Laravel.

## Pré-requisitos
- PHP 8.1+
- Composer
- Token de API da Iugu

## Configuração

1. **Instale as dependências:**
   ```bash
   composer install
   ```

2. **Configure o token de API:**
   - Defina a variável de ambiente `IUGU_API_TOKEN` com seu token de API:
     ```bash
     export IUGU_API_TOKEN="seu_token_aqui"
     ```
   - Ou edite o arquivo `config/iugu.php` e substitua `'SEU_TOKEN_AQUI'` pelo seu token.
   - Você pode usar um arquivo `.env` (fora do Laravel) e carregar com [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv):
     ```php
     // No seu bootstrap.php
     if (file_exists(__DIR__ . '/../.env')) {
         $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
         $dotenv->load();
     }
     ```

3. **(Opcional) Configure outros dados sensíveis**
   - Para exemplos que exigem IDs de cliente, fatura, plano, etc., substitua os valores nos arquivos de exemplo.

## Como rodar um exemplo

Execute qualquer exemplo diretamente pelo terminal:

```bash
php examples/invoices/create_invoice.php
```

## Instanciação do Client

A partir da versão atual, **não é mais necessário passar parâmetros para o client**. Basta:

```php
use Iugu\Infrastructure\Http\IuguHttpClient;
$client = new IuguHttpClient();
```

A configuração é lida automaticamente de `config/iugu.php` e das variáveis de ambiente, usando os helpers globais `env()` e `config()` (já disponíveis via autoload do Composer).

## Sumário dos Exemplos Disponíveis

- **Faturas (Invoices):**
  - `invoices/create_invoice.php`
  - `invoices/get_invoice.php`
  - `invoices/list_invoices.php`
  - `invoices/cancel_invoice.php`
- **Clientes (Customers):**
  - `customers/create_customer.php`
  - `customers/get_customer.php`
  - `customers/list_customers.php`
  - `customers/delete_customer.php`
- **Carnês (Bills):**
  - `bills/create_bill.php`
  - `bills/get_bill.php`
  - `bills/list_bills.php`
  - `bills/cancel_bill.php`
- **Assinaturas (Subscriptions):**
  - `subscriptions/create_subscription.php`
  - `subscriptions/get_subscription.php`
  - `subscriptions/list_subscriptions.php`
  - `subscriptions/cancel_subscription.php`
- **Formas de Pagamento:**
  - `payment_methods/create_payment_method.php`
  - `payment_methods/get_payment_method.php`
  - `payment_methods/list_payment_methods.php`
  - `payment_methods/delete_payment_method.php`
- **Planos:**
  - `plans/create_plan.php`
  - `plans/get_plan.php`
  - `plans/list_plans.php`
  - `plans/delete_plan.php`
- **Multi Split:**
  - `splits/create_split.php`
  - `splits/get_split.php`
  - `splits/list_splits.php`
  - `splits/delete_split.php`
  - `splits/list_invoice_splits.php`
- **Transferências:**
  - `transfers/transfer_value.php`
  - `transfers/get_transfer.php`
  - `transfers/list_transfers.php`
- **Webhooks:**
  - `webhooks/create_webhook.php`
  - `webhooks/get_webhook.php`
  - `webhooks/list_webhooks.php`
- **Tokens de Pagamento:**
  - `payment_tokens/create_payment_token.php`
- **API Tokens:**
  - `api_tokens/create_api_token.php`
- **Cobrança Direta com 2 Cartões:**
  - `direct_charges/charge_two_credit_cards.php`
- **Zero Auth (Validação de Cartão):**
  - `zero_auth/validate_card.php`

## Integração com Laravel

Você pode usar os casos de uso diretamente em controllers/services do Laravel. Exemplo de Service Provider:

```php
// app/Providers/IuguServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Iugu\Application\Invoices\CreateInvoiceUseCase;

class IuguServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(IuguHttpClient::class, function ($app) {
            return new IuguHttpClient();
        });
        $this->app->bind(CreateInvoiceUseCase::class, function ($app) {
            return new CreateInvoiceUseCase($app->make(IuguHttpClient::class));
        });
        // ...outros casos de uso
    }
}
```

No Controller:
```php
public function store(Request $request, CreateInvoiceUseCase $useCase)
{
    $invoice = $useCase->execute($request->all());
    // ...
}
```

## Observações
- Os exemplos são didáticos e podem ser adaptados conforme a necessidade do seu projeto.
- Consulte a documentação oficial da Iugu para detalhes de cada campo e resposta da API.
- Os helpers `env()` e `config()` já estão disponíveis globalmente via autoload do Composer.

---

Dúvidas ou sugestões? Abra uma issue ou contribua! 