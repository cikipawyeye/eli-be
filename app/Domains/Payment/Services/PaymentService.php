<?php

declare(strict_types=1);

namespace App\Domains\Payment\Services;

use App\Domains\Payment\DataTransferObjects\PaymentRequest\CreatePaymentData;
use App\Domains\Payment\DataTransferObjects\PaymentRequest\EWalletObjectData;
use App\Domains\Payment\DataTransferObjects\PaymentRequest\OverTheCounterObjectData;
use App\Domains\Payment\DataTransferObjects\PaymentRequest\QRCodeObjectData;
use App\Domains\Payment\DataTransferObjects\PaymentRequest\VirtualAccountObjectData;
use App\Domains\Payment\Enums\EWalletChannelCode;
use App\Domains\Payment\Enums\PaymentMethodType as Type;
use Illuminate\Support\Str;
use Xendit\PaymentMethod\PaymentMethodApi;
use Xendit\PaymentRequest\EWalletChannelProperties;
use Xendit\PaymentRequest\EWalletParameters;
use Xendit\PaymentRequest\OverTheCounterChannelProperties;
use Xendit\PaymentRequest\OverTheCounterParameters;
use Xendit\PaymentRequest\PaymentMethodParameters;
use Xendit\PaymentRequest\PaymentMethodReusability;
use Xendit\PaymentRequest\PaymentMethodType;
use Xendit\PaymentRequest\PaymentRequest;
use Xendit\PaymentRequest\PaymentRequestApi;
use Xendit\PaymentRequest\PaymentRequestParameters;
use Xendit\PaymentRequest\PaymentRequestCurrency;
use Xendit\PaymentRequest\QRCodeChannelProperties;
use Xendit\PaymentRequest\QRCodeParameters;
use Xendit\PaymentRequest\VirtualAccountParameters;
use Xendit\PaymentRequest\VirtualAccountChannelProperties;

class PaymentService extends AbstractPaymentService
{
    protected PaymentRequestApi $apiInstance;

    protected PaymentRequestParameters $parameter;

    protected CreatePaymentData $data;

    protected int $amount;

    protected string $custName;

    public function requestPayment(?int $amount = null, ?CreatePaymentData $paymentData = null): PaymentRequest
    {
        if ($amount) {
            $this->setAmount($amount);
        }

        if ($paymentData) {
            $this->setData($paymentData);
        }

        $this->setApiInstance()
            ->setCustomerName()
            ->setPaymentRequest()
            ->setPaymentMethod();

        return $this->apiInstance->createPaymentRequest(
            payment_request_parameters: $this->parameter,
        );
    }

    protected function setApiInstance(): self
    {
        $this->apiInstance = new PaymentRequestApi();

        return $this;
    }

    protected function setPaymentRequest(): self
    {
        $this->parameter = (new PaymentRequestParameters())
            ->setAmount($this->amount)
            ->setCurrency(PaymentRequestCurrency::IDR);

        return $this;
    }

    protected function setCustomerName(): self
    {
        /** @disregard P1013 */
        /** @var \App\Domains\User\Models\User $user */
        $user = auth()->user();
        $this->custName = preg_replace('/[^A-Za-z0-9 ]/', '', $user->name);

        return $this;
    }

    protected function setPaymentMethod(): self
    {
        match ($this->data->payment_type->value) {
            Type::VIRTUAL_ACCOUNT->value => $this->useVirtualAccount($this->data->payment_property),
            Type::OVER_THE_COUNTER->value => $this->useOverTheCounter($this->data->payment_property),
            Type::QR_CODE->value => $this->useQR($this->data->payment_property),
            Type::EWALLET->value => $this->useEWallet($this->data->payment_property),
        };

        return $this;
    }

    protected function useVirtualAccount(VirtualAccountObjectData $property): self
    {
        $vaObject = (new VirtualAccountParameters())
            ->setChannelCode($property->channel_code->value)
            ->setAmount($this->amount)
            ->setChannelProperties(
                (new VirtualAccountChannelProperties())
                    ->setCustomerName($this->custName)
                    ->setExpiresAt(now()->addDays())
            );

        $paymentMethod = (new PaymentMethodParameters())
            ->setVirtualAccount($vaObject)
            ->setType(PaymentMethodType::VIRTUAL_ACCOUNT)
            ->setReusability(PaymentMethodReusability::ONE_TIME_USE);

        $this->parameter->setPaymentMethod($paymentMethod);

        return $this;
    }

    protected function useOverTheCounter(OverTheCounterObjectData $property): self
    {
        $counterObject = (new OverTheCounterParameters())
            ->setChannelCode($property->channel_code->value)
            ->setAmount($this->amount)
            ->setChannelProperties(
                (new OverTheCounterChannelProperties())
                    ->setCustomerName($this->custName)
                    ->setExpiresAt(now()->addDays())
            );

        $paymentMethod = (new PaymentMethodParameters())
            ->setType(PaymentMethodType::OVER_THE_COUNTER)
            ->setOverTheCounter($counterObject)
            ->setReusability(PaymentMethodReusability::ONE_TIME_USE);

        $this->parameter->setPaymentMethod($paymentMethod);

        return $this;
    }

    protected function useQR(QRCodeObjectData $property): self
    {
        $qrObject = (new QRCodeParameters())
            ->setChannelCode($property->channel_code->value)
            ->setChannelProperties(
                (new QRCodeChannelProperties())
                    ->setQrString(Str::orderedUuid()->toString())
                    ->setExpiresAt(now()->addDays())
            );

        $paymentMethod = (new PaymentMethodParameters())
            ->setType(PaymentMethodType::QR_CODE)
            ->setQrCode($qrObject)
            ->setReusability(PaymentMethodReusability::ONE_TIME_USE);

        $this->parameter->setPaymentMethod($paymentMethod);

        return $this;
    }

    protected function useEWallet(EWalletObjectData $property): self
    {
        $channelProperty = (new EWalletChannelProperties())
            ->setSuccessReturnUrl(config('app.url'))
            ->setFailureReturnUrl(config('app.url')); // change this

        if ($property->channel_code->value == EWalletChannelCode::OVO->value) {
            $channelProperty->setMobileNumber($property->phone_number);
        }

        $eWalletObject = (new EWalletParameters())
            ->setChannelCode($property->channel_code->value)
            ->setChannelProperties(
                $channelProperty
            );

        $paymentMethod = (new PaymentMethodParameters())
            ->setType(PaymentMethodType::EWALLET)
            ->setEwallet($eWalletObject)
            ->setReusability(PaymentMethodReusability::ONE_TIME_USE);

        $this->parameter->setPaymentMethod($paymentMethod);

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getData(): ?CreatePaymentData
    {
        return $this->data;
    }

    public function setData(CreatePaymentData $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getPaymentStatus(string $paymentRequestId): \Xendit\PaymentRequest\PaymentRequestStatus|string
    {
        /** @var \Xendit\PaymentRequest\PaymentRequestStatus */
        $status = (new PaymentRequestApi()) // NOSONAR
            ->getPaymentRequestByID($paymentRequestId)
            ->getStatus();

        return $status;
    }

    /**
     * Simulate payment method (Sandbox only)
     */
    public function simulate(string $paymentMethodId, int $amount)
    {
        if ('production' == app()->environment()) {
            return;
        }

        $pm = new PaymentMethodApi();
        $pm->simulatePayment(
            payment_method_id: $paymentMethodId,
            simulate_payment_request: (new \Xendit\PaymentMethod\SimulatePaymentRequest())->setAmount($amount)
        );
    }

    /**
     * Simulate expire payment method (Sandbox only)
     */
    public function expire(string $paymentMethodId)
    {
        if ('production' == app()->environment()) {
            return;
        }

        $pm = new PaymentMethodApi();
        $pm->expirePaymentMethod(
            payment_method_id: $paymentMethodId
        );
    }
}
