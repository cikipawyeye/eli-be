<?php

declare(strict_types=1);

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\DataTransferObjects\PaymentRequest\CreatePaymentData;
use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Pending;
use App\Domains\Payment\Exceptions\UpgradeAccountException;
use App\Domains\Payment\Services\Facade\PaymentService;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;

class UpgradeAccountAction extends Action
{
    public function __construct(
        protected readonly CreatePaymentData $paymentData,
        protected readonly User $user,
    ) {}

    public function handle(): Payment
    {
        if ($this->user->is_premium) {
            throw UpgradeAccountException::alreadyPremium();
        }

        $payment = $this->user->payments()
            ->where('state', Pending::$name)
            ->first();

        if ($payment) {
            return $payment;
        }

        $payment =$this->makePaymentRequest();
        $payment->user()->associate($this->user);
        $payment->save();

        return $payment;
    }

    protected function makePaymentRequest(): Payment
    {
        $paymentRequest = PaymentService::requestPayment(
            amount: config('app.upgrade_price'),
            paymentData: $this->paymentData
        );

        return new Payment([
            'x_payment_id' => null,
            'x_payment_request_id'  => $paymentRequest?->getId(),
            'x_payment_method_id'  => $paymentRequest?->getPaymentMethod()->getId(),
            'amount' => $paymentRequest->getAmount(),
            'payment_method_type' => $paymentRequest->getPaymentMethod()->getType(),
        ]);
    }
}
