<?php

namespace App\Domains\Payment\Actions;

use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\States\Payment\Succeeded;
use App\Domains\User\Models\User;
use App\Support\Actions\Action;
use Illuminate\Support\Facades\DB;

class DeletePaymentAction extends Action
{
    public function __construct(
        protected readonly Payment $model,
    ) {}

    public function handle(): void
    {
        $userId = $this->model->user_id;
        $userPaymentCount = Payment::where('user_id', $userId)
            ->where('state', Succeeded::$name)
            ->count();

        DB::transaction(function () use ($userPaymentCount, $userId) {
            $this->model->delete();

            if ($userPaymentCount === 1) {
                User::where('id', $userId)->update([
                    'is_premium' => false,
                ]);
            }
        });
    }
}
