<?php

declare(strict_types=1);

namespace Iugu\Application\DirectCharges;

use Iugu\Application\DirectCharges\Requests\ChargeTwoCreditCardsRequest;
use Iugu\Domain\DirectCharges\CreditCardTransaction;
use Iugu\Domain\DirectCharges\DirectChargeTwoCreditCardsResult;
use Iugu\Domain\DirectCharges\InvoiceStatus;
use Iugu\Infrastructure\Http\IuguHttpClient;
use Exception;

final class ChargeTwoCreditCardsUseCase
{
    private IuguHttpClient $httpClient;

    public function __construct(IuguHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param ChargeTwoCreditCardsRequest $request
     * @return DirectChargeTwoCreditCardsResult
     * @throws Exception
     */
    public function execute(ChargeTwoCreditCardsRequest $request): DirectChargeTwoCreditCardsResult
    {
        $response = $this->httpClient->post(
            '/v1/charge_two_credit_cards',
            $request->toArray()
        );

        $data = json_decode($response->getBody()->getContents());

        if (!isset($data->invoice) || !isset($data->invoice->status)) {
            throw new Exception('Resposta da API inválida: campo invoice ausente.');
        }

        $transactions = array_map(function ($transactionData) {
            return new CreditCardTransaction(
                reversible: $transactionData->reversible,
                last4: $transactionData->last4,
                bin: $transactionData->bin,
                brand: $transactionData->brand,
                token: $transactionData->token,
                message: $transactionData->message,
                success: $transactionData->success,
                issuer: $transactionData->issuer ?? null,
                invoice_id: $transactionData->invoice_id,
                lr: $transactionData->LR ?? null
            );
        }, $data->credit_card_transactions ?? []);

        return new DirectChargeTwoCreditCardsResult(
            invoice: new InvoiceStatus(
                status: $data->invoice->status
            ),
            credit_card_transactions: $transactions,
            errors: isset($data->errors) ? (array) $data->errors : null
        );
    }
} 