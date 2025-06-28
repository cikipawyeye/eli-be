<?php

declare(strict_types=1);

namespace App\Domains\Notification\Actions;

use App\Domains\Notification\DataTransferObjects\ReminderNotificationData;
use App\Support\Actions\AsyncAction;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Spatie\LaravelData\Lazy;

class SendPushNotificationAction extends AsyncAction
{
    const TOPIC = 'reminder';

    public function __construct(
        protected readonly ReminderNotificationData $reminderNotificationData
    ) {}

    public function handle()
    {
        $image = $this->reminderNotificationData->image_url_optimized;

        if ($image instanceof Lazy) {
            // Resolve the Lazy image URL to get the actual URL
            $image = $image->resolve();
        }

        $messaging = Firebase::messaging();
        
        $message = CloudMessage::new()
            ->withNotification([
                'title' => $this->reminderNotificationData->title,
                'body' => $this->reminderNotificationData->message,
                'image' => $image,
            ])
            ->withAndroidConfig([
                'notification' => [
                    'color' => '#0e2341',
                    // Notification sound can be set here if needed
                    'channel_id' => 'reminder_notification_channel',
                ]
            ])
            ->withData([
                'reminderNotificationId' => $this->reminderNotificationData->id,
            ])
            ->toTopic(self::TOPIC);

        try {
            $messaging->send($message);
        } catch (MessagingException $e) {
            // Handle the exception as needed, e.g., log it or rethrow it
            // For now, we will just log the error message
            Log::error('Failed to send push notification', [
                'error' => $e->getMessage(),
                'data' => $this->reminderNotificationData->toArray(),
            ]);
        }
    }
}
