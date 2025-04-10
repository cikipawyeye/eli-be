<?php

declare(strict_types=1);

namespace App\Domains\Theme\Actions;

use App\Domains\Theme\Models\Music;
use App\Support\Actions\Action;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StoreMusicAction extends Action
{
    public function __construct(
        protected readonly string $title,
        protected readonly UploadedFile $file
    ) {}

    public function handle()
    {
        $model = new Music();
        $model->fill([
            'title' => $this->title,
        ]);

        DB::transaction(function () use ($model) {
            $model->save();
            $model->addMedia($this->file)->toMediaCollection('content');
        });

        return $model;
    }
}
