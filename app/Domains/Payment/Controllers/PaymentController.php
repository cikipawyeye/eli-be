<?php

namespace App\Domains\Payment\Controllers;

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
        $this->middleware(sprintf('permission:%s', Permission::ADD_PAYMENT))->only('store');
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
