# Iugu PHP SDK

Package PHP 8.1+ para integração com a API da Iugu, seguindo Clean Architecture, PSR-4, tipagem estrita e compatível com Laravel e outros frameworks.

## Instalação

```bash
composer require eloca/iugu-php
```

## Configuração

1. **Copie o arquivo de configuração:**
   - Copie `config/iugu.php` para o diretório `config/` do seu projeto (se não estiver lá).

2. **Defina as variáveis de ambiente:**
   - No Laravel, adicione ao seu `.env`:
     ```env
     IUGU_API_TOKEN=seu_token_aqui
     IUGU_API_BASE_URL=https://api.iugu.com/v1/
     IUGU_API_TIMEOUT=10
     ```
   - Fora do Laravel, defina as variáveis de ambiente no seu sistema ou use um arquivo `.env` e [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv):
     ```php
     // No seu bootstrap.php
     if (file_exists(__DIR__ . '/.env')) {
         $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
         $dotenv->load();
     }
     ```

3. **Helpers globais:**
   - As funções `env()` e `config()` já estão disponíveis globalmente via autoload do Composer.

## Instanciação do Client

**Não é mais necessário passar parâmetros para o client.**

```php
use Iugu\Infrastructure\Http\IuguHttpClient;
$client = new IuguHttpClient();
```

A configuração é lida automaticamente de `config/iugu.php` e das variáveis de ambiente.

## Exemplos de Uso

Veja a pasta [`examples/`](examples/README.md) para exemplos práticos de todos os casos de uso:
- Faturas (Invoices)
- Clientes (Customers)
- Carnês (Bills)
- Assinaturas (Subscriptions)
- Formas de Pagamento
- Planos
- Multi Split
- Transferências
- Webhooks
- Tokens de Pagamento, API Tokens, Cobrança Direta com 2 Cartões, Zero Auth

Execute qualquer exemplo via terminal:
```bash
php examples/invoices/create_invoice.php
```

## Integração com Laravel

Exemplo de Service Provider:
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
- Helpers `env()` e `config()` disponíveis globalmente via autoload do Composer.
- Consulte a documentação oficial da Iugu para detalhes de cada campo e resposta da API.
- Exemplos práticos em [`examples/`](examples/README.md).

---

Dúvidas ou sugestões? Abra uma issue ou contribua!
