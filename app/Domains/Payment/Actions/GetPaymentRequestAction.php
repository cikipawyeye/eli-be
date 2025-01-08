<?php

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\Models\Payment;
use App\Support\Actions\Action;
use Xendit\PaymentRequest\PaymentRequest;
use Xendit\PaymentRequest\PaymentRequestApi;

class GetPaymentRequestAction extends Action
{
    public function __construct(
        protected readonly Payment $model,
    ) {}

    public function handle(): ?PaymentRequest
    {
        if (empty($this->model->x_payment_request_id)) {
            return null;
        }

        return (new PaymentRequestApi())
            ->getPaymentRequestByID($this->model->x_payment_request_id);
    }
}
