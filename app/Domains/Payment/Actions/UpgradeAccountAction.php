<?php

declare(strict_types=1);

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\Enums\EWalletChannelCode;
use App\Domains\Payment\Enums\OverTheCounterChannelCode;
use App\Domains\Payment\Enums\PaymentMethodType;
use App\Domains\Payment\Enums\QRCodeChannelCode;
use App\Domains\Payment\Enums\VirtualAccountChannelCode;
use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Pending;
use App\Domains\Payment\Exceptions\UpgradeAccountException;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;

class UpgradeAccountAction extends Action
{
    public function __construct(
        protected readonly PaymentMethodType $method,
        protected readonly VirtualAccountChannelCode|OverTheCounterChannelCode|QRCodeChannelCode|EWalletChannelCode $channel,
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

        $payment = (new Payment())->fill([
            'x_payment_id' => null,
            'x_payment_request_id'  => null,
            'x_payment_method_id'  => null,
            'amount' => 55000,
            'payment_method_type' => $this->method->value,
        ]);
        $payment->user()->associate($this->user);
        $payment->save();

        return $payment;
    }
}
