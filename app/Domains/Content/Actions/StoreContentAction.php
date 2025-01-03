<?php

declare(strict_types=1);

namespace App\Domains\Content\Actions;

use App\Domains\Content\DataTransferObject\ContentData;
use App\Domains\Content\Models\Content;
use App\Support\Actions\Action;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class StoreContentAction extends Action
{
    public function __construct(
        protected readonly Content $model,
        protected readonly ContentData $data,
        protected readonly UploadedFile $image
    ) {}

    public function handle()
    {
        $this->model->subcategory()->associate($this->data->subcategory_id);
        $this->model->fill($this->data->only('title', 'premium')->toArray());

        DB::transaction(function () {
            $this->model->save();
            $this->model->addMedia($this->image)->toMediaCollection('content');
        });

        return $this->model;
    }
}
