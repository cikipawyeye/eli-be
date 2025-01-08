<?php

declare(strict_types=1);

namespace App\Domains\Payment\Services\Facade;

use App\Domains\Payment\Services\AbstractPaymentService;
use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Domains\Payment\Services\PaymentService
 */

/**
 * @method static ?int getAmount()
 *
 * @method static \App\Domains\Payment\Services\PaymentService setAmount(int $amount)
 *
 * @method static \App\Domains\Payment\DataTransferObjects\PaymentRequest\CreatePaymentData getData()
 *
 * @method static \App\Domains\Payment\Services\PaymentService setData(\App\Domains\Payment\DataTransferObjects\PaymentRequest\CreatePaymentData $paymentData)
 *
 * @method static \Xendit\PaymentRequest\PaymentRequest requestPayment(int $amount, \App\Domains\Payment\DataTransferObjects\PaymentRequest\CreatePaymentData $paymentData)
 *
 * @method static void simulate(string $paymentMethodId, int $amount)
 *
 * @method static void expire(string $paymentMethodId)
 *
 * @method static \Xendit\PaymentRequest\PaymentRequestStatus|string getPaymentStatus(string $paymentRequestId)
 */
class PaymentService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return AbstractPaymentService::class;
    }
}
