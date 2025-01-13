<?php

declare(strict_types=1);

namespace App\Domains\Payment\Controllers\API;

use App\Domains\Payment\Actions\HandlePaymentMethodNotificationAction;
use App\Domains\Payment\Actions\HandlePaymentNotificationAction;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentWebhookController extends ApiController
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\VerifyXenditCallbackToken::class);
    }

    /**
     * Validate payment status.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $callback = new \Xendit\PaymentRequest\PaymentCallback($request->all());

        dispatch_sync(new HandlePaymentNotificationAction($callback));

        return $this->sendJsonResponse(status: 204);
    }

    /**
     * Validate payment method status.
     */
    public function paymentMethod(Request $request): JsonResponse
    {
        $callback = new \Xendit\PaymentMethod\PaymentMethodCallback($request->all());

        dispatch_sync(new HandlePaymentMethodNotificationAction($callback));

        return $this->sendJsonResponse(status: 204);
    }
}
