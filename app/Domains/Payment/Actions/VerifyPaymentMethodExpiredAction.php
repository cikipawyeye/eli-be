<?php

declare(strict_types=1);

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\Services\Facade\PaymentService;
use App\Domains\Payment\States\Payment\Failed;
use App\Domains\Payment\States\PaymentRequest\Succeeded;
use App\Support\Actions\AsyncAction;
use Illuminate\Support\Facades\DB;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class VerifyPaymentMethodExpiredAction extends AsyncAction
{
    public function __construct(
        protected readonly Payment $payment,
    ) {}

    /**
     * @throws CouldNotPerformTransition
     */
    public function handle(): void
    {
        $paymentStatus = PaymentService::getPaymentStatus($this->payment->x_payment_request_id);

        if ($paymentStatus != Succeeded::$name) {
            DB::transaction(function () {
                if ($this->payment->state->canTransitionTo(Failed::$name)) {
                    $this->payment->state->transitionTo(Failed::$name);
                } else {
                    info('Could not perform transition to failed state', [
                        'payment' => $this->payment,
                    ]);
                    throw CouldNotPerformTransition::couldNotResolveTransitionField($this->payment);
                }
            });
        }
    }
}
