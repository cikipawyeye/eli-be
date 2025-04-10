<?php

declare(strict_types=1);

namespace App\Domains\Theme\Actions;

use App\Domains\Theme\Models\Wallpaper;
use App\Support\Actions\Action;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StoreWallpaperAction extends Action
{
    public function __construct(
        protected readonly string $name,
        protected readonly UploadedFile $file
    ) {}

    public function handle()
    {
        $model = new Wallpaper();
        $model->fill([
            'name' => $this->name,
            // jpeg,png,jpg,gif,webp,mp4
            'type' => $this->file->getClientOriginalExtension() === 'mp4'
                ? 'video'
                : 'image',
        ]);

        DB::transaction(function () use ($model) {
            $model->save();
            $model->addMedia($this->file)->toMediaCollection('content');
        });

        return $model;
    }
}
