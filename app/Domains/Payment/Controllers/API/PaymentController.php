<?php

namespace App\Domains\Payment\Controllers\API;

use App\Domains\Payment\Actions\GetPaymentRequestAction;
use App\Domains\Payment\Exceptions\PaymentException;
use App\Domains\Payment\Models\Payment;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class PaymentController extends ApiController
{
    /**
     * Display the specified resource.
     */
    public function show(Payment $payment): JsonResponse
    {
        /** @disregard P1013 */
        if ($payment->user_id !== auth()->user()->id) {
            throw PaymentException::notFound();
        }

        /** @var \Xendit\PaymentRequest\PaymentRequest */
        $paymentRequest = GetPaymentRequestAction::dispatchSync($payment);
        /** @var \Xendit\PaymentRequest\PaymentMethod */
        $paymentMethod = $paymentRequest->getPaymentMethod();

        return $this->sendJsonResponse([
            'status' => $paymentRequest->getStatus(),
            'required_actions' => $paymentRequest->getActions(),
            'payment_method' => [
                'type' => $paymentMethod->getType(),
                'ewallet' => $paymentMethod->getEwallet(),
                'over_the_counter' => $paymentMethod->getOverTheCounter(),
                'qr_code' => $paymentMethod->getQrCode(),
                'virtual_account' => $paymentMethod->getVirtualAccount(),
            ]
        ]);
    }
}
