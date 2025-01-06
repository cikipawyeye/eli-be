<?php

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\DataTransferObjects\PaymentData;
use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\PaymentState;
use App\Domains\Payment\States\Payment\Succeeded;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;
use Illuminate\Support\Facades\DB;

class StorePaymentAction extends Action
{
    public function __construct(
        protected readonly PaymentData $data,
    ) {}

    public function handle()
    {
        $payment = new Payment();
        $payment->fill($this->data->toArray());
        $payment->user()->associate($this->data->user_id);

        if ($this->data->state && ($this->data->state instanceof PaymentState || is_string($this->data->state))) {
            $payment->state = $this->data->state;
        }

        DB::transaction(function () use ($payment) {
            $payment->save();

            if (
                $this->data->state instanceof Succeeded ||
                $this->data->state === Succeeded::$name
            ) {
                User::where('id', $payment->user_id)->update([
                    'is_premium' => true,
                ]);
            }
        });

        return $payment;
    }
}
