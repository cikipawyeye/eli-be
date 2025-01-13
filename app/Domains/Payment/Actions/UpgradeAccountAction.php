<?php

declare(strict_types=1);

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\DataTransferObjects\PaymentRequest\CreatePaymentData;
use App\Domains\Payment\Exceptions\UpgradeAccountException;
use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\Services\Facade\PaymentService;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;
use Xendit\PaymentRequest\PaymentRequest;

class UpgradeAccountAction extends Action
{
    public function __construct(
        protected readonly CreatePaymentData $paymentData,
        protected readonly User $user,
    ) {}

    public function handle(): array
    {
        if ($this->user->is_premium) {
            throw UpgradeAccountException::alreadyPremium();
        }

        $paymentRequest = $this->makePaymentRequest();

        $payment = new Payment([
            'x_payment_id' => null,
            'x_payment_request_id' => $paymentRequest?->getId(),
            'x_payment_method_id' => $paymentRequest?->getPaymentMethod()->getId(),
            'amount' => $paymentRequest->getAmount(),
            'payment_method_type' => $paymentRequest->getPaymentMethod()->getType(),
        ]);
        $payment->user()->associate($this->user);
        $payment->save();

        return [
            'payment' => $this->transformData($paymentRequest),
            'payment_id' => $payment->id,
        ];
    }

    protected function makePaymentRequest(): PaymentRequest
    {
        return PaymentService::requestPayment(
            amount: config('app.upgrade_price'),
            paymentData: $this->paymentData
        );
    }

    protected function transformData(PaymentRequest $paymentRequest): array
    {
        /** @var \Xendit\PaymentRequest\PaymentMethod */
        $paymentMethod = $paymentRequest->getPaymentMethod();

        return [
            'status' => $paymentRequest->getStatus(),
            'required_actions' => $paymentRequest->getActions(),
            'payment_method' => [
                'type' => $paymentMethod->getType(),
                'ewallet' => $paymentMethod->getEwallet(),
                'over_the_counter' => $paymentMethod->getOverTheCounter(),
                'qr_code' => $paymentMethod->getQrCode(),
                'virtual_account' => $paymentMethod->getVirtualAccount(),
            ],
        ];
    }
}
