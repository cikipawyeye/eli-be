<?php

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\DataTransferObjects\PaymentData;
use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Pending;
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
        if (!($this->data->state instanceof Pending) && $this->data->state !== Pending::$name) {
            $payment->state = $this->data->state;
        }

        DB::transaction(function () use ($payment) {
            $payment->save();
        });

        return $payment;
    }
}
