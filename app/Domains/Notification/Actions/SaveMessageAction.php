<?php

declare(strict_types=1);

namespace App\Domains\Notification\Actions;

use App\Domains\Notification\DataTransferObjects\MessageData;
use App\Domains\Notification\Models\Message;
use App\Support\Actions\Action;

class SaveMessageAction extends Action
{
    public function __construct(
        protected readonly Message $model,
        protected readonly MessageData $data
    ) {}

    public function handle()
    {
        $this->model->fill($this->data->only(
            'content',
        )->toArray());

        $this->model->emotion()->associate(
            $this->data->emotion_id
        );

        $this->model->save();

        return $this->model;
    }
}
