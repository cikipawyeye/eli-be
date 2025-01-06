<?php

namespace App\Domains\Payment\Controllers;

use App\Domains\Payment\Actions\DeletePaymentAction;
use App\Domains\Payment\Actions\UpdatePaymentAction;
use App\Domains\Payment\DataTransferObjects\PaymentData;
use App\Domains\Payment\Models\Payment;
use App\Domains\Payment\Repositories\PaymentCriteria;
use App\Domains\Payment\Repositories\PaymentRepository;
use App\Domains\Payment\Requests\StorePaymentRequest;
use App\Domains\Payment\Requests\UpdatePaymentRequest;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_PAYMENTS))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::READ_PAYMENT))->only('show');
        $this->middleware(sprintf('permission:%s', Permission::EDIT_PAYMENT))->only('update');
        $this->middleware(sprintf('permission:%s', Permission::DELETE_PAYMENT))->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $criteria = PaymentCriteria::from($request->all());
        $repository = new PaymentRepository($criteria);
        $paginate = 'false' == $request->boolean('paginate');

        return Inertia::render('Payment/Index', [
            'criteria' => Inertia::always($criteria),
            'data' => Inertia::defer(fn() => $this->resource(PaymentData::class, $paginate
                ? $repository->get()
                : $repository->paginate($request->all()), 'user')),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return Inertia::render('Payment/Show', [
            'data' => PaymentData::fromModel($payment)->include('user'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        dispatch_sync(new UpdatePaymentAction(
            $payment,
            PaymentData::from([
                ...$request->validated(),
                'user_id' => $request->user()->id,
            ])
        ));

        return redirect()
            ->route('payments.show', ['payment' => $payment])
            ->with('success', __('app.updated_data', ['data' => __('app.payment')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        dispatch_sync(new DeletePaymentAction($payment));

        return redirect()
            ->route('payments.index')
            ->with('success', __('app.deleted_data', ['data' => __('app.payment')]));
    }
}
