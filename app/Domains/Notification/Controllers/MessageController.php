<?php

namespace App\Domains\Notification\Controllers;

use App\Domains\Notification\Actions\SaveMessageAction;
use App\Domains\Notification\DataTransferObjects\MessageData;
use App\Domains\Notification\Models\Message;
use App\Domains\Notification\Requests\SaveMessageRequest;

class MessageController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveMessageRequest $request)
    {
        dispatch_sync(
            new SaveMessageAction(
                new Message(),
                MessageData::from($request->validated())
            )
        );

        return back()
            ->with('success', __('app.updated_data', ['data' => __('app.message')]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveMessageRequest $request, Message $message)
    {
        dispatch_sync(
            new SaveMessageAction(
                $message,
                MessageData::from($request->validated())
            )
        );

        return back()
            ->with('success', __('app.updated_data', ['data' => __('app.message')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->delete();

        return back()
            ->with('success', __('app.deleted_data', ['data' => __('app.message')]));
    }
}
