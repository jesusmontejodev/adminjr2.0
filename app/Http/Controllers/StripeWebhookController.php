<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class StripeWebhookController extends CashierController
{
    /**
     * Handle invoice payment succeeded.
     */
    protected function handleInvoicePaymentSucceeded(array $payload)
    {
        parent::handleInvoicePaymentSucceeded($payload);

        $invoice = $payload['data']['object'];
        $customerId = $invoice['customer'];

        Log::info('Pago de factura exitoso', [
            'customer_id' => $customerId,
            'invoice_id' => $invoice['id'],
            'amount_paid' => $invoice['amount_paid'] / 100,
        ]);
    }

    /**
     * Handle subscription updated.
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        parent::handleCustomerSubscriptionUpdated($payload);

        $subscription = $payload['data']['object'];

        Log::info('Suscripción actualizada', [
            'subscription_id' => $subscription['id'],
            'status' => $subscription['status'],
            'current_period_end' => date('Y-m-d', $subscription['current_period_end']),
        ]);
    }

    /**
     * Handle subscription deleted/canceled.
     */
    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        parent::handleCustomerSubscriptionDeleted($payload);

        $subscription = $payload['data']['object'];

        Log::warning('Suscripción cancelada', [
            'subscription_id' => $subscription['id'],
            'customer_id' => $subscription['customer'],
        ]);
    }

    /**
     * Handle payment failed.
     */
    protected function handleInvoicePaymentFailed(array $payload)
    {
        parent::handleInvoicePaymentFailed($payload);

        $invoice = $payload['data']['object'];

        Log::error('Pago fallido', [
            'invoice_id' => $invoice['id'],
            'customer_id' => $invoice['customer'],
            'attempt_count' => $invoice['attempt_count'],
        ]);
    }
}
