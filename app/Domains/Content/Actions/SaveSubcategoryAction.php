<?php

namespace App\Domains\Content\Actions;

use App\Domains\Content\DataTransferObject\SubcategoryData;
use App\Domains\Content\Models\Subcategory;
use App\Support\Actions\Action;

class SaveSubcategoryAction extends Action
{
    public function __construct(
        protected readonly Subcategory $model,
        protected readonly SubcategoryData $data
    ) {}

    public function handle()
    {
        $this->model->fill($this->data->only(
            'name',
            'category',
            'is_active',
        )->toArray());
        $this->model->save();
        
        return $this->model;
    }
}
