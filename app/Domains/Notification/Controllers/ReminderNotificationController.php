<?php

namespace App\Domains\Notification\Controllers;

use App\Domains\Notification\Actions\SaveReminderNotificationAction;
use App\Domains\Notification\DataTransferObjects\ReminderNotificationData;
use App\Domains\Notification\Requests\StoreReminderNotificationRequest;
use App\Domains\Notification\Requests\UpdateReminderNotificationRequest;
use App\Domains\Notification\Models\ReminderNotification;
use App\Domains\Notification\Repositories\ReminderNotificationCriteria;
use App\Domains\Notification\Repositories\ReminderNotificationRepository;
use App\Domains\User\Constants\PermissionConstant as Permission;
use App\Support\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $activeReminderNotification = ReminderNotification::where('is_active', true)
            ->first();

        return Inertia::render('Notification/ReminderNotification/Index', [
            'criteria' => Inertia::always($criteria),
            'data' => Inertia::defer(fn() => $this->resource(ReminderNotificationData::class, $paginate
                ? $repository->get()
                : $repository->paginate($request->all()))),
            'active' => $activeReminderNotification ? ReminderNotificationData::fromModel($activeReminderNotification) : null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReminderNotificationRequest $request)
    {
        $remoinderNotification = new ReminderNotification();

        dispatch_sync(
            new SaveReminderNotificationAction(
                $remoinderNotification,
                ReminderNotificationData::from($request->validated())
            )
        );

        return redirect()
            ->route('reminder-notifications.show', $remoinderNotification)
            ->with('success', __('app.stored_data', ['data' => __('app.reminder_notification')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(ReminderNotification $reminderNotification)
    {
        return Inertia::render('Notification/ReminderNotification/Show', [
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

    /**
     * Set the specified resource as active.
     */
    public function setActive(ReminderNotification $reminderNotification): RedirectResponse
    {
        DB::transaction(function () use ($reminderNotification) {
            ReminderNotification::where('is_active', true)
                ->update(['is_active' => false]);

            $reminderNotification->update(['is_active' => true]);
        });

        return redirect()
            ->back();
    }

    /**
     * Disable all active reminder notifications.
     */
    public function disable(): RedirectResponse
    {
        ReminderNotification::where('is_active', true)
            ->update(['is_active' => false]);

        return redirect()
            ->back();
    }
}
