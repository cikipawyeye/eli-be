<?php

declare(strict_types=1);

namespace App\Domains\Payment\Controllers\API;

use App\Domains\Payment\Actions\HandlePaymentNotificationAction;
use App\Support\Controllers\ApiController;
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
    public function __invoke(Request $request)
    {
        $callback = new \Xendit\PaymentRequest\PaymentCallback($request->all());

        dispatch_sync(new HandlePaymentNotificationAction($callback));

        return $this->sendJsonResponse(status: 204);
    }
}
