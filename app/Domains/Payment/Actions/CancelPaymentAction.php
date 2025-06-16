<?php

declare(strict_types=1);

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Canceled;
use App\Domains\Payment\States\Payment\Succeeded;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;
use Illuminate\Support\Facades\DB;

class CancelPaymentAction extends Action
{
    public function __construct(
        protected readonly Payment $model,
    ) {}

    public function handle(): void
    {
        if (! $this->model->state->canTransitionTo(Canceled::$name)) {
            throw \App\Domains\Payment\Exceptions\PaymentException::cannotCancel();
        }

        $prevState = $this->model->state;

        DB::transaction(function () use ($prevState) {
            $this->model->state->transitionTo(Canceled::$name);

            if (! ($prevState instanceof Succeeded)) {
                return;
            }

            // we need to check if the user has any other successful payments
            $userId = $this->model->user_id;
            $userPaymentCount = Payment::where('user_id', $userId)
                ->where('state', Succeeded::$name)
                ->count();

            if ($userPaymentCount < 1) {
                User::where('id', $userId)->update([
                    'is_premium' => false,
                ]);
            }
        });
    }
}
