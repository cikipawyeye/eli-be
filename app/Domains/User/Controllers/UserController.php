<?php

namespace App\Domains\User\Controllers;

use App\Domains\User\Actions\DeleteUserAction;
use App\Domains\User\Actions\SaveUserAction;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Domains\User\DataTransferObjects\UserData;
use App\Domains\User\Enums\RoleEnum;
use App\Domains\User\Models\User;
use App\Domains\User\Repositories\UserCriteria;
use App\Domains\User\Repositories\UserRepository;
use App\Domains\User\Requests\SaveUserRequest;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_USERS))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::READ_USER))->only('show');
        $this->middleware(sprintf('permission:%s', Permission::ADD_USER))->only('store');
        $this->middleware(sprintf('permission:%s', Permission::EDIT_USER))->only('update');
        $this->middleware(sprintf('permission:%s', Permission::DELETE_USER))->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $criteria = UserCriteria::from([
            ...$request->all(),
            'role' => RoleEnum::User->value,
        ]);
        $repository = new UserRepository($criteria);
        $paginate = 'false' == $request->boolean('paginate');

        return Inertia::render('User/User/Index', [
            'criteria' => Inertia::always($criteria),
            'data' => Inertia::defer(fn() => $this->resource(UserData::class, $paginate
                ? $repository->get()
                : $repository->paginate($request->all()))),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveUserRequest $request)
    {
        $user = dispatch_sync(new SaveUserAction(new User(), UserData::from($request->validated())));

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with('success', __('app.stored_data', ['data' => __('app.user')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Inertia::render('User/User/Show', [
            'data' => fn() => UserData::fromModel($user),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveUserRequest $request, User $user)
    {
        dispatch_sync(new SaveUserAction($user, UserData::from($request->validated())));

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with('success', __('app.updated_data', ['data' => __('app.user')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $user)
    {
        dispatch_sync(new DeleteUserAction($user));

        return redirect()
            ->route('users.index')
            ->with('success', __('app.deleted_data', ['data' => __('app.user')]));
    }
}