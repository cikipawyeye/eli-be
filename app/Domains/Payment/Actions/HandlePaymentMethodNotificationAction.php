<?php

declare(strict_types=1);

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Canceled;
use App\Domains\Payment\States\Payment\Failed;
use App\Support\Actions\Action;
use Illuminate\Support\Facades\DB;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class HandlePaymentMethodNotificationAction extends Action
{
    public function __construct(
        protected readonly \Xendit\PaymentMethod\PaymentMethodCallback $data,
    ) {}

    /**
     * @throws CouldNotPerformTransition
     */
    public function handle(): void
    {
        $event = $this->data->getEvent();

        // Only handle failed / expired payment
        if ('payment_method.activated' == $event) {
            return;
        }

        $paymentMethod = new \Xendit\PaymentMethod\PaymentMethod($this->data->getData());
        /** @var Payment $payment */
        $payment = Payment::firstWhere('x_payment_method_id', $paymentMethod->getId());

        if (empty($payment)) {
            info('Payment not found for payment method', json_decode($this->data->__toString(), true));

            return;
        }

        if ($payment->state instanceof Canceled) {
            info('Payment already canceled', json_decode($this->data->__toString(), true));

            return;
        }

        // handle expired payment
        if ('payment_method.expired' == $event) {
            VerifyPaymentMethodExpiredAction::dispatch($payment);
            return;
        }

        // handle failed payment
        DB::transaction(function () use ($payment) {
            if ($payment->state->canTransitionTo(Failed::$name)) {
                $payment->state->transitionTo(Failed::$name)->refresh();
            } else {
                info('Could not perform transition to failed state', [
                    'payment' => $payment,
                    'data' => json_decode($this->data->__toString(), true),
                ]);
                throw CouldNotPerformTransition::couldNotResolveTransitionField($payment);
            }
        });
    }
}
