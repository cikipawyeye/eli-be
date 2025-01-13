<?php

declare(strict_types=1);

namespace App\Domains\Payment\Requests;

use App\Domains\Payment\Enums\PaymentMethodType;
use App\Domains\Payment\States\Payment\Failed;
use App\Domains\Payment\States\Payment\Pending;
use App\Domains\Payment\States\Payment\Succeeded;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')->withoutTrashed()],
            'x_payment_id' => ['nullable', 'string'],
            'x_payment_request_id' => ['nullable', 'string'],
            'x_payment_method_id' => ['nullable', 'string'],
            'amount' => ['required', 'integer', 'min:0'],
            'payment_method_type' => ['required', 'string', Rule::enum(PaymentMethodType::class)],
            'state' => ['required', Rule::in(Pending::$name, Succeeded::$name, Failed::$name)],
        ];
    }
}
