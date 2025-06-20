<?php

declare(strict_types=1);

namespace App\Domains\Notification\Actions;

use App\Domains\Notification\DataTransferObjects\EmotionData;
use App\Domains\Notification\Models\Emotion;
use App\Support\Actions\Action;

class SaveEmotionAction extends Action
{
    public function __construct(
        protected readonly Emotion $model,
        protected readonly EmotionData $data
    ) {}

    public function handle()
    {
        $this->model->fill($this->data->only(
            'name',
        )->toArray());

        $this->model->save();

        return $this->model;
    }
}
