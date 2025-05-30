<?php

declare(strict_types=1);

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Canceled;
use App\Domains\Payment\States\Payment\Succeeded;
use App\Support\Actions\Action;
use Illuminate\Support\Facades\DB;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class HandlePaymentNotificationAction extends Action
{
    public function __construct(
        protected readonly \Xendit\PaymentRequest\PaymentCallback $data,
    ) {}

    /**
     * @throws CouldNotPerformTransition
     */
    public function handle(): void
    {
        $callbackData = new \Xendit\PaymentRequest\PaymentCallbackData($this->data->getData());

        /** @var Payment $payment */
        $payment = Payment::firstWhere('x_payment_request_id', $callbackData->getPaymentRequestId());

        if (! $payment) {
            info('Payment not found', json_decode($this->data->__toString(), true));

            return;
        }

        if ($payment->state instanceof Canceled) {
            info('Payment already canceled', json_decode($this->data->__toString(), true));

            return;
        }

        DB::transaction(function () use ($payment, $callbackData) {
            /**
             * Possible values:
             * - SUCCEEDED
             * - FAILED
             * @var string $status
             */
            $status = $callbackData->getStatus();

            if ($payment->state->canTransitionTo($status)) {
                $payment->state->transitionTo($status)->refresh();
            } else {
                throw CouldNotPerformTransition::couldNotResolveTransitionField($payment);
            }

            if ($payment->state instanceof Succeeded) {
                $payment->user()->update([
                    'is_premium' => true,
                ]);
            }

            $payment->update([
                'x_payment_id' => $callbackData->getId(),
            ]);
        });
    }
}
