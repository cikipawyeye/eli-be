<?php

namespace App\Domains\Setting\Controllers;

use App\Domains\Setting\Actions\SaveReminderNotificationAction;
use App\Domains\Setting\DataTransferObjects\ReminderNotificationData;
use App\Domains\Setting\Requests\StoreReminderNotificationRequest;
use App\Domains\Setting\Requests\UpdateReminderNotificationRequest;
use App\Domains\Setting\Models\ReminderNotification;
use App\Domains\Setting\Repositories\ReminderNotificationCriteria;
use App\Domains\Setting\Repositories\ReminderNotificationRepository;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Support\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReminderNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(sprintf('permission:%s', Permission::BROWSE_REMINDER_NOTIFICATIONS))->only('index');
        $this->middleware(sprintf('permission:%s', Permission::READ_REMINDER_NOTIFICATION))->only('show');
        $this->middleware(sprintf('permission:%s', Permission::ADD_REMINDER_NOTIFICATION))->only('store');
        $this->middleware(sprintf('permission:%s', Permission::EDIT_REMINDER_NOTIFICATION))->only('update');
        $this->middleware(sprintf('permission:%s', Permission::DELETE_REMINDER_NOTIFICATION))->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $criteria = ReminderNotificationCriteria::from($request->all());
        $repository = new ReminderNotificationRepository($criteria);
        $paginate = 'false' == $request->boolean('paginate');

        return Inertia::render('Setting/ReminderNotification/Index', [
            'criteria' => Inertia::always($criteria),
            'data' => Inertia::defer(fn() => $this->resource(ReminderNotificationData::class, $paginate
                ? $repository->get()
                : $repository->paginate($request->all()))),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReminderNotificationRequest $request)
    {
        dispatch_sync(
            new SaveReminderNotificationAction(
                new ReminderNotification,
                ReminderNotificationData::from($request->validated())
            )
        );

        return back()
            ->with('success', __('app.stored_data', ['data' => __('app.reminder_notification')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(ReminderNotification $reminderNotification)
    {
        return Inertia::render('Setting/ReminderNotification/Show', [
            'data' => ReminderNotificationData::fromModel($reminderNotification),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReminderNotificationRequest $request, ReminderNotification $reminderNotification)
    {
        dispatch_sync(
            new SaveReminderNotificationAction(
                $reminderNotification,
                ReminderNotificationData::from($request->validated())
            )
        );

        return back()
            ->with('success', __('app.updated_data', ['data' => __('app.reminder_notification')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReminderNotification $reminderNotification)
    {
        $reminderNotification->delete();

        return redirect()
            ->route('reminder-notifications.index')
            ->with('success', __('app.deleted_data', ['data' => __('app.reminder_notification')]));
    }
}
