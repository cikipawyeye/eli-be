<?php

namespace App\Console\Commands;

use App\Domains\Notification\Actions\SendPushNotificationAction;
use App\Domains\Notification\DataTransferObjects\ReminderNotificationData;
use App\Domains\Notification\Models\ReminderNotification;
use Illuminate\Console\Command;

class SendReminderPushNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-reminder-push-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send firebase push notification for active reminder notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reminderNotification = ReminderNotification::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->first();

        if (!$reminderNotification) {
            $datetime = now()->toDateTimeString();
            $this->warn("[{$datetime}] No active reminder notification found.");
            return;
        }

        // Get current time
        $currentTime = now()->format('H:i');
        if (substr($reminderNotification->notification_time, 0, 5) !== $currentTime) {
            $datetime = now()->toDateTimeString();
            $this->warn("[{$datetime}] Time does not match current time. Skipping.");
            return;
        }

        dispatch_sync(
            new SendPushNotificationAction(
                ReminderNotificationData::fromModel($reminderNotification)->include('image_url_optimized')
            )
        );
    }
}
