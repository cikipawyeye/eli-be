<?php

declare(strict_types=1);

namespace App\Domains\Payment\Requests\API;

use App\Domains\Payment\Enums\EWalletChannelCode;
use App\Domains\Payment\Enums\OverTheCounterChannelCode;
use App\Domains\Payment\Enums\PaymentMethodType;
use App\Domains\Payment\Enums\QRCodeChannelCode;
use App\Domains\Payment\Enums\VirtualAccountChannelCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePaymentRequest extends FormRequest
{
    public function attributes()
    {
        return [
            'payment_type' => __('app.payment_type'),
            'channel_code' => __('app.payment_channel_code'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_type' => [
                'required',
                Rule::enum(PaymentMethodType::class),
            ],
            'channel_code' => [
                'required',
                fn(string $attr, mixed $val, \Closure $fail) => $this->validatePaymentMethod($attr, $val, $fail),
            ],
        ];
    }

    protected function validatePaymentMethod(string $attribute, string $value, \Closure $fail): void
    {
        switch ($this->payment_type) {
            case PaymentMethodType::VIRTUAL_ACCOUNT->value:
                if (! in_array($value, VirtualAccountChannelCode::toArray())) {
                    $fail(__('validation.in', ['attribute' => $attribute]));
                }
                break;

            case PaymentMethodType::OVER_THE_COUNTER->value:
                if (! in_array($value, OverTheCounterChannelCode::toArray())) {
                    $fail(__('validation.in', ['attribute' => $attribute]));
                }
                break;

            case PaymentMethodType::QR_CODE->value:
                if (! in_array($value, QRCodeChannelCode::toArray())) {
                    $fail(__('validation.in', ['attribute' => $attribute]));
                }
                break;

            case PaymentMethodType::EWALLET->value:
                if (! in_array($value, EWalletChannelCode::toArray())) {
                    $fail(__('validation.in', ['attribute' => $attribute]));
                }
                break;

            default:
                $fail(__('validation.in', ['attribute' => $attribute]));
                break;
        }
    }

    public function getPaymentType(): PaymentMethodType
    {
        return PaymentMethodType::fromValue($this->payment_type);
    }

    public function getChannelCode(): VirtualAccountChannelCode|OverTheCounterChannelCode|QRCodeChannelCode|EWalletChannelCode
    {
        return match ($this->payment_type) {
            PaymentMethodType::VIRTUAL_ACCOUNT->value => VirtualAccountChannelCode::fromValue($this->channel_code),
            PaymentMethodType::OVER_THE_COUNTER->value => OverTheCounterChannelCode::fromValue($this->channel_code),
            PaymentMethodType::QR_CODE->value => QRCodeChannelCode::fromValue($this->channel_code),
            PaymentMethodType::EWALLET->value => EWalletChannelCode::fromValue($this->channel_code),
        };
    }
}
