<?php

declare(strict_types=1);

namespace App\Domains\Notification\Actions;

use App\Domains\User\Models\User;
use App\Support\Actions\AsyncAction;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class SendDeviceLoginNotificationAction extends AsyncAction
{
    public function __construct(
        protected readonly User $user,
        protected readonly string $newDeviceId,
        protected readonly string $newFcmToken
    ) {}

    public function handle(): void
    {
        $oldFcmToken = $this->user->fcm_token;
        $shouldSendNotification = $this->user->device_id !== $this->newDeviceId
            && ! empty($this->newFcmToken)
            && ! empty($oldFcmToken);

        $data = [
            'device_id' => $this->newDeviceId,
            'fcm_token' => $this->newFcmToken,
        ];
        $data = array_filter($data, fn($value) => ! is_null($value) && $value !== '');

        if (! empty($data)) {
            $this->user->update($data);
        }

        if ($shouldSendNotification) {
            $this->sendNotification($oldFcmToken);
        }
    }

    protected function sendNotification(string $fcmToken): void
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
            ->toToken($fcmToken);

        try {
            $messaging->send($message);
        } catch (MessagingException $e) {
            Log::error('Failed to send device login notification', [
                'error' => $e->getMessage(),
                'device_id' => $this->newDeviceId,
                'fcm_token' => $fcmToken,
            ]);
        }
    }
}
