<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use YooKassa\Client;

class PaymentWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $event = $request->getContent();
        $eventData = json_decode($event, true);

        Log::info('Получено событие от ЮKassa', ['event' => $eventData]);

        switch ($eventData['event']) {
            case 'payment.waiting_for_capture':
                $this->handlePaymentWaitingForCapture($eventData);
                break;
            case 'payment.succeeded':
                $this->handlePaymentSucceeded($eventData);
                break;
            case 'payment.canceled':
                $this->handlePaymentCanceled($eventData);
                break;
            case 'refund.succeeded':
                $this->handleRefundSucceeded($eventData);
                break;
            default:
                Log::info('Неизвестное событие', ['event' => $eventData['event']]);
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    protected function handlePaymentWaitingForCapture($eventData)
    {
        $paymentId = $eventData['object']['id'];
        Log::info('Платеж ожидает подтверждения', ['payment_id' => $paymentId]);

        $this->capturePayment($paymentId);
    }

    protected function handlePaymentSucceeded($eventData)
    {
        $paymentId = $eventData['object']['id'];
        $amount = $eventData['object']['amount']['value'];
        $currency = $eventData['object']['amount']['currency'];

        Log::info('Платеж успешен', [
            'payment_id' => $paymentId,
            'amount' => $amount,
            'currency' => $currency
        ]);

        $this->updateOrderStatus($paymentId, 'paid');
    }

    protected function handlePaymentCanceled($eventData)
    {
        $paymentId = $eventData['object']['id'];
        Log::info('Платеж отменен', ['payment_id' => $paymentId]);

        $this->refundPayment($paymentId);
    }

    protected function handleRefundSucceeded($eventData)
    {
        $paymentId = $eventData['object']['payment_id'];
        $refundAmount = $eventData['object']['amount']['value'];
        Log::info('Возврат средств успешен', ['payment_id' => $paymentId, 'refund_amount' => $refundAmount]);

        $this->updateRefundStatus($paymentId, $refundAmount);
    }

    protected function capturePayment($paymentId)
    {
        $client = new Client();
        $client->setAuth(env('YOOKASSA_SHOP_ID'), env('YOOKASSA_SECRET_KEY'));

        try {
            $client->capturePayment($paymentId);
            Log::info('Платеж подтвержден', ['payment_id' => $paymentId]);

            $this->updateOrderStatus($paymentId, 'captured');
        } catch (\Exception $e) {
            Log::error('Ошибка при подтверждении платежа', ['error' => $e->getMessage()]);
        }
    }

    protected function updateOrderStatus($paymentId, $status)
    {
        Log::info("Обновляем статус заказа для платежа $paymentId на $status");
    }

    protected function refundPayment($paymentId)
    {
        $client = new Client();
        $client->setAuth(env('YOOKASSA_SHOP_ID'), env('YOOKASSA_SECRET_KEY'));

        try {
            $client->refundPayment($paymentId, 100);
            Log::info('Платеж возвращен', ['payment_id' => $paymentId]);
        } catch (\Exception $e) {
            Log::error('Ошибка при возврате платежа', ['error' => $e->getMessage()]);
        }
    }

    protected function updateRefundStatus($paymentId, $amount)
    {
        // Логика обновления статуса возврата в базе данных
        Log::info("Обновляем статус возврата для платежа $paymentId на сумму $amount");
    }
}
