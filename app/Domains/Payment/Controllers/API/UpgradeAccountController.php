<?php

declare(strict_types=1);

namespace App\Domains\Payment\Controllers\API;

use App\Domains\Payment\Actions\UpgradeAccountAction;
use App\Domains\Payment\Constants\AccountUpgradeStatus;
use App\Domains\Payment\DataTransferObjects\PaymentData;
use App\Domains\Payment\DataTransferObjects\PaymentRequest\CreatePaymentData;
use App\Domains\Payment\Requests\API\CreatePaymentRequest;
use App\Domains\Payment\States\Payment\Pending;
use App\Domains\User\Enums\RoleEnum;
use App\Support\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpgradeAccountController extends ApiController
{
    public function __construct()
    {
        $this->middleware(sprintf('role:%s', RoleEnum::User->value));
    }

    public function status(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->is_premium) {
            return $this->sendJsonResponse(
                data: [
                    'status' => AccountUpgradeStatus::PREMIUM,
                    'payment' => null,
                ],
            );
        }

        $payment = $user->payments()
            ->where('state', Pending::$name)
            ->orderByDesc('created_at')
            ->first();

        return $this->sendJsonResponse(
            data: [
                'status' => $payment ? AccountUpgradeStatus::PENDING_PAYMENT : AccountUpgradeStatus::NOT_PREMIUM,
                'payment' => $payment
                    ? PaymentData::fromModel($payment)
                        ->only('id', 'amount', 'payment_method_type', 'state')
                    : null,
            ],
        );
    }

    public function createPayment(CreatePaymentRequest $request): JsonResponse
    {
        $payment = dispatch_sync(new UpgradeAccountAction(
            CreatePaymentData::fromRequest($request),
            user: $request->user(),
        ));

        return $this->sendJsonResponse(
            data: $payment,
        );
    }
}
