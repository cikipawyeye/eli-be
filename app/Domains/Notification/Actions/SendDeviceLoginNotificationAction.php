<?php

declare(strict_types=1);

namespace App\Domains\Notification\Actions;

use App\Support\Actions\AsyncAction;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class SendDeviceLoginNotificationAction extends AsyncAction
{
    public function __construct(
        public readonly ?string $newDeviceId,
        public readonly ?string $oldFcmToken
    ) {}

    public function handle(): void
    {
        $shouldSendNotification = ! empty($this->newDeviceId)
            && ! empty($this->oldFcmToken);

        if ($shouldSendNotification) {
            $this->sendNotification();
        }
    }

    protected function sendNotification(): void
    {
        $messaging = Firebase::messaging();

        $message = CloudMessage::new()
            ->withNotification([
                'title' => 'Device Login',
                'body' => 'A new device has logged in to your account.',
            ])
            ->withData([
                'device_id' => $this->newDeviceId,
            ])
            ->toToken($this->oldFcmToken);

        try {
            $messaging->send($message);
        } catch (MessagingException $e) {
            Log::error('Failed to send device login notification', [
                'error' => $e->getMessage(),
                'device_id' => $this->newDeviceId,
                'fcm_token' => $this->oldFcmToken,
            ]);
        }
    }
}
