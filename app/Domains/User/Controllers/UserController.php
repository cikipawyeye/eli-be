<?php

declare(strict_types=1);

namespace App\Domains\User\Controllers;

use App\Domains\Payment\Actions\StorePaymentAction;
use App\Domains\Payment\DataTransferObjects\PaymentData;
use App\Domains\Payment\Requests\StorePaymentRequest;
use App\Domains\User\Actions\DeleteUserAction;
use App\Domains\User\Actions\SaveUserAction;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Domains\User\DataTransferObjects\UserData;
use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Models\City;
use App\Domains\User\Models\User;
use App\Domains\User\Repositories\UserCriteria;
use App\Domains\User\Repositories\UserRepository;
use App\Domains\User\Requests\SaveUserRequest;
use App\Support\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_USERS))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::READ_USER))->only('show');
        $this->middleware(sprintf('permission:%s', Permission::ADD_USER))->only('create', 'store');
        $this->middleware(sprintf('permission:%s', Permission::EDIT_USER))->only('edit', 'update');
        $this->middleware(sprintf('permission:%s', Permission::DELETE_USER))->only('destroy');
        $this->middleware(sprintf('permission:%s', Permission::ADD_PAYMENT))->only('addPayment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Inertia\Response
    {
        $criteria = UserCriteria::from([
            ...$request->all(),
            'role' => RoleEnum::User->value,
        ]);
        $repository = new UserRepository($criteria);
        $paginate = 'false' == $request->boolean('paginate');

        return Inertia::render('User/User/Index', [
            'criteria' => Inertia::always($criteria),
            'data' => Inertia::defer(fn () => $this->resource(UserData::class, $paginate
                ? $repository->get()
                : $repository->paginate($request->all()))),
        ]);
    }

    public function create(): \Inertia\Response
    {
        return inertia('User/User/Add', [
            'cities' => City::select('code', 'name')->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveUserRequest $request): RedirectResponse
    {
        $user = dispatch_sync(new SaveUserAction(new User, UserData::from($request->validated())));

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with('success', __('app.stored_data', ['data' => __('app.user')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): \Inertia\Response
    {
        return Inertia::render('User/User/Show', [
            'data' => fn () => UserData::fromModel($user)->include('city'),
            'payments' => Inertia::defer(fn () => $this->resource(PaymentData::class, $user->payments()->orderByDesc('created_at')->get())),
        ]);
    }

    public function edit(User $user): \Inertia\Response
    {
        return inertia('User/User/Edit', [
            'data' => UserData::fromModel($user),
            'cities' => City::select('code', 'name')->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveUserRequest $request, User $user): RedirectResponse
    {
        dispatch_sync(new SaveUserAction($user, UserData::from($request->validated())));

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with('success', __('app.updated_data', ['data' => __('app.user')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $user): RedirectResponse
    {
        dispatch_sync(new DeleteUserAction($user));

        return redirect()
            ->route('users.index')
            ->with('success', __('app.deleted_data', ['data' => __('app.user')]));
    }

    public function addPayment(StorePaymentRequest $request, int $user): RedirectResponse
    {
        dispatch_sync(new StorePaymentAction(PaymentData::from([
            ...$request->validated(),
            'user_id' => $user,
        ])));

        return redirect()
            ->route('users.show', ['user' => $user])
            ->with('success', __('app.stored_data', ['data' => __('app.payment')]));
    }
}
