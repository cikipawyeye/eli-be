<?php

declare(strict_types=1);

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\DataTransferObjects\PaymentData;
use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Succeeded;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;
use Illuminate\Support\Facades\DB;

class UpdatePaymentAction extends Action
{
    public function __construct(
        protected readonly Payment $model,
        protected readonly PaymentData $data,
    ) {}

    public function handle()
    {
        $otherUserPaymentCount = Payment::where('user_id', $this->model->user_id)
            ->where('state', Succeeded::$name)
            ->whereNot('id', $this->model->id)
            ->count();

        $this->model->fill($this->data->toArray());
        $this->model->state->transitionTo($this->data->state);

        DB::transaction(function () use ($otherUserPaymentCount) {
            $this->model->save();

            if (! ($this->model->state instanceof Succeeded) && 0 == $otherUserPaymentCount) {
                User::where('id', $this->model->user_id)->update([
                    'is_premium' => false,
                ]);
            } elseif ($this->model->state instanceof Succeeded) {
                User::where('id', $this->model->user_id)->update([
                    'is_premium' => true,
                ]);
            }
        });

        return $this->model;
    }
}
